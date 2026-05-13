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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json
            $table->timestamps();
        });

        // Seed default settings
        DB::table('settings')->insert([
            ['key' => 'expiry_reminder_days', 'value' => '3', 'type' => 'integer', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'inactivity_days', 'value' => '7', 'type' => 'integer', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'enable_notifications', 'value' => 'true', 'type' => 'boolean', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'timezone', 'value' => 'UTC', 'type' => 'string', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
