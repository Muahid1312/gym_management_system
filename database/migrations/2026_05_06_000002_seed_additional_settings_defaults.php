<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $defaults = [
            'currency' => ['value' => 'USD', 'type' => 'string'],
            'currency_symbol' => ['value' => '$', 'type' => 'string'],
            'currency_position' => ['value' => 'before', 'type' => 'string'],
            'default_plan_duration' => ['value' => '1', 'type' => 'integer'],
            'allow_partial_payments' => ['value' => 'false', 'type' => 'boolean'],
            'enable_debt_system' => ['value' => 'false', 'type' => 'boolean'],
            'enable_email_notifications' => ['value' => 'true', 'type' => 'boolean'],
            'notification_reminder_days' => ['value' => '3', 'type' => 'integer'],
            'enable_whatsapp_notifications' => ['value' => 'false', 'type' => 'boolean'],
            'enable_offline_mode' => ['value' => 'false', 'type' => 'boolean'],
            'auto_backup_enabled' => ['value' => 'false', 'type' => 'boolean'],
            'backup_retention_count' => ['value' => '7', 'type' => 'integer'],
            'theme' => ['value' => 'light', 'type' => 'string'],
            'accent_color' => ['value' => 'blue', 'type' => 'string'],
        ];

        foreach ($defaults as $key => $entry) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                [
                    'value' => $entry['value'],
                    'type' => $entry['type'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $keys = [
            'currency',
            'currency_symbol',
            'currency_position',
            'default_plan_duration',
            'allow_partial_payments',
            'enable_debt_system',
            'enable_email_notifications',
            'notification_reminder_days',
            'enable_whatsapp_notifications',
            'enable_offline_mode',
            'auto_backup_enabled',
            'backup_retention_count',
            'theme',
            'accent_color',
        ];

        DB::table('settings')->whereIn('key', $keys)->delete();
    }
};
