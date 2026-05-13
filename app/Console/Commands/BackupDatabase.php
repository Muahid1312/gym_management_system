<?php

namespace App\Console\Commands;

use App\Services\BackupService;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';

    protected $description = 'Create a database backup in storage/app/backups';

    public function handle(BackupService $service): int
    {
        $backupName = $service->createBackup();

        $this->info('Database backup created: ' . $backupName);

        return self::SUCCESS;
    }
}
