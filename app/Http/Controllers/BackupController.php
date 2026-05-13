<?php

namespace App\Http\Controllers;

use App\Services\BackupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class BackupController extends Controller
{
    public function index(BackupService $backupService)
    {
        $backups = $backupService->listBackups();

        return view('backups.index', compact('backups'));
    }

    public function store(BackupService $backupService)
    {
        $backupName = $backupService->createBackup();

        return Redirect::back()->with('success', "Backup created successfully: {$backupName}");
    }

    public function download(string $filename, BackupService $backupService)
    {
        $path = $backupService->getBackupPath($filename);

        return Response::download($path, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    public function destroy(string $filename, BackupService $backupService)
    {
        $backupService->deleteBackup($filename);

        return Redirect::back()->with('success', 'Backup deleted successfully.');
    }

    public function restore(Request $request, BackupService $backupService)
    {
        $data = $request->validate([
            'backup_name' => 'required|string',
        ]);

        try {
            $backupService->restoreBackup($data['backup_name']);

            return Redirect::back()->with('success', 'Database restored successfully from backup.');
        } catch (\Throwable $exception) {
            return Redirect::back()->with('error', 'Restore failed: ' . $exception->getMessage());
        }
    }

    public function uploadRestore(Request $request, BackupService $backupService)
    {
        $data = $request->validate([
            'backup_file' => 'required|file|mimes:sql,sqlite|max:10240',
        ]);

        try {
            $backupService->restoreUploadedBackup($request->file('backup_file'));

            return Redirect::back()->with('success', 'Database restored successfully from uploaded backup.');
        } catch (\Throwable $exception) {
            return Redirect::back()->with('error', 'Restore failed: ' . $exception->getMessage());
        }
    }
}
