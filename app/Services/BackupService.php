<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class BackupService
{
    public function createBackup(): string
    {
        $this->ensureBackupDirectoryExists();

        $connection = $this->getConnectionType();
        $timestamp = now()->format('Y_m_d_His');

        if ($connection === 'sqlite') {
            return $this->createSqliteBackup($timestamp);
        }

        if (in_array($connection, ['mysql', 'mariadb'], true)) {
            return $this->createMysqlBackup($timestamp);
        }

        throw new RuntimeException("Backup not supported for connection type: {$connection}");
    }

    public function listBackups(): array
    {
        $this->ensureBackupDirectoryExists();

        $files = Storage::disk('local')->files('backups');
        $backups = [];

        foreach ($files as $file) {
            $name = basename($file);

            if (! preg_match('/^backup_\d{4}_\d{2}_\d{2}_\d{6}\.(sql|sqlite|zip)$/', $name)) {
                continue;
            }

            $backups[] = [
                'name' => $name,
                'size' => Storage::disk('local')->size($file),
                'modified' => Storage::disk('local')->lastModified($file),
            ];
        }

        usort($backups, fn ($a, $b) => $b['modified'] <=> $a['modified']);

        return $backups;
    }

    public function deleteBackup(string $filename): void
    {
        if (! $this->isValidBackupFilename($filename)) {
            throw new RuntimeException('Invalid backup file selected.');
        }

        $path = $this->getBackupPath($filename);

        if (! file_exists($path)) {
            throw new RuntimeException('Backup file not found.');
        }

        Storage::disk('local')->delete('backups/' . $filename);
    }

    public function restoreBackup(string $filename): void
    {
        if (! $this->isValidBackupFilename($filename)) {
            throw new RuntimeException('Invalid backup file selected for restore.');
        }

        $path = $this->getBackupPath($filename);

        if (! file_exists($path)) {
            throw new RuntimeException('Backup file not found.');
        }

        $connection = $this->getConnectionType();

        if ($connection === 'sqlite') {
            if (str_ends_with($filename, '.sqlite')) {
                copy($path, $this->getSqliteDatabasePath());
                return;
            }

            $command = sprintf(
                'sqlite3 %s %s',
                escapeshellarg($this->getSqliteDatabasePath()),
                escapeshellarg('.read ' . $path)
            );

            exec($command, $output, $status);

            if ($status !== 0) {
                throw new RuntimeException('SQLite restore failed: ' . implode("\n", $output));
            }

            return;
        }

        if (in_array($connection, ['mysql', 'mariadb'], true)) {
            $command = $this->buildMysqlRestoreCommand($path);
            exec($command, $output, $status);

            if ($status !== 0) {
                throw new RuntimeException('MySQL restore failed: ' . implode("\n", $output));
            }

            return;
        }

        throw new RuntimeException("Restore not supported for connection type: {$connection}");
    }

    public function restoreUploadedBackup(UploadedFile $file): void
    {
        if (! in_array($file->extension(), ['sql', 'sqlite'], true)) {
            throw new RuntimeException('Uploaded backup must be a .sql or .sqlite file.');
        }

        $filename = 'backup_' . now()->format('Y_m_d_His') . '.' . $file->extension();
        $this->ensureBackupDirectoryExists();

        $path = Storage::disk('local')->path('backups/' . $filename);
        $file->move(dirname($path), basename($path));

        $this->restoreBackup($filename);
    }

    public function getBackupPath(string $filename): string
    {
        if (! $this->isValidBackupFilename($filename)) {
            throw new RuntimeException('Invalid backup file selected.');
        }

        return Storage::disk('local')->path('backups/' . $filename);
    }

    protected function isValidBackupFilename(string $filename): bool
    {
        return (bool) preg_match('/^backup_\d{4}_\d{2}_\d{2}_\d{6}\.(sql|sqlite|zip)$/', $filename);
    }

    protected function ensureBackupDirectoryExists(): void
    {
        if (! Storage::disk('local')->exists('backups')) {
            Storage::disk('local')->makeDirectory('backups');
        }
    }

    protected function getBackupDirectory(): string
    {
        return Storage::disk('local')->path('backups');
    }

    protected function getConnectionType(): string
    {
        return Config::get('database.default');
    }

    protected function getSqliteDatabasePath(): string
    {
        $path = Config::get('database.connections.sqlite.database');

        if ($path === ':memory:') {
            throw new RuntimeException('Cannot restore in-memory SQLite database.');
        }

        // If path is already absolute, return it directly
        if (DIRECTORY_SEPARATOR === '\\') {
            // Windows: check for drive letter
            if (strlen($path) > 1 && $path[1] === ':') {
                return $path;
            }
        } else {
            // Unix: check for leading /
            if (str_starts_with($path, '/')) {
                return $path;
            }
        }

        // Otherwise, resolve relative to database directory
        return database_path($path);
    }

    protected function createMysqlBackup(string $timestamp): string
    {
        $connection = $this->getConnectionType();
        $path = $this->getBackupDirectory() . DIRECTORY_SEPARATOR . "backup_{$timestamp}.sql";
        $config = Config::get("database.connections.{$connection}");

        $command = implode(' ', array_filter([
            'mysqldump',
            '--user=' . escapeshellarg($config['username'] ?? ''),
            '--password=' . escapeshellarg($config['password'] ?? ''),
            '--host=' . escapeshellarg($config['host'] ?? '127.0.0.1'),
            '--port=' . escapeshellarg($config['port'] ?? '3306'),
            $config['unix_socket'] ? '--socket=' . escapeshellarg($config['unix_socket']) : null,
            '--default-character-set=utf8mb4',
            '--single-transaction',
            '--skip-lock-tables',
            escapeshellarg($config['database'] ?? ''),
            '>',
            escapeshellarg($path),
        ]));

        exec($command, $output, $status);

        if ($status !== 0) {
            throw new RuntimeException('MySQL backup failed: ' . implode("\n", $output));
        }

        return basename($path);
    }

    protected function createSqliteBackup(string $timestamp): string
    {
        $databasePath = $this->getSqliteDatabasePath();
        $target = $this->getBackupDirectory() . DIRECTORY_SEPARATOR . "backup_{$timestamp}.sqlite";

        if (! file_exists($databasePath)) {
            throw new RuntimeException('SQLite database file not found.');
        }

        copy($databasePath, $target);

        return basename($target);
    }

    protected function buildMysqlRestoreCommand(string $path): string
    {
        $connection = $this->getConnectionType();
        $config = Config::get("database.connections.{$connection}");

        return implode(' ', array_filter([
            'mysql',
            '--user=' . escapeshellarg($config['username'] ?? ''),
            '--password=' . escapeshellarg($config['password'] ?? ''),
            '--host=' . escapeshellarg($config['host'] ?? '127.0.0.1'),
            '--port=' . escapeshellarg($config['port'] ?? '3306'),
            $config['unix_socket'] ? '--socket=' . escapeshellarg($config['unix_socket']) : null,
            escapeshellarg($config['database'] ?? ''),
            '<',
            escapeshellarg($path),
        ]));
    }
}
