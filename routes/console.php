<?php

use App\Services\NotificationService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('membership:notify', function () {
    $service = app(NotificationService::class);
    $service->sendExpiryNotifications();
    $this->info('Membership notification process completed.');
})->purpose('Send email notifications for expiring or expired gym memberships');

Artisan::command('backup:database', function () {
    $filename = 'backup_' . now()->format('Y_m_d_H_i_s') . '.sql';
    $path = storage_path('backups/' . $filename);

    // Simple backup (for MySQL)
    $command = "mysqldump -u" . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . " > \"$path\"";
    exec($command);

    $this->info('Database backup created: ' . $filename);
})->purpose('Create a database backup');
