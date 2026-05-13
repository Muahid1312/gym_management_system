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

