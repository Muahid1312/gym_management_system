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
        Schema::create('gym_info', function (Blueprint $table) {
            $table->id();
            $table->string('gym_name')->default('Gym Management System');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });

        // Create a single record for singleton pattern
        DB::table('gym_info')->insert([
            [
                'gym_name' => 'Gym Management System',
                'address' => '123 Main Street, City, State',
                'phone' => '+1 (000) 000-0000',
                'email' => 'contact@gym.local',
                'logo_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_info');
    }
};
