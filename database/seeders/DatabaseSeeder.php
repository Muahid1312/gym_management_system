<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default gym membership plans.
        \App\Models\Plan::insert([
            ['name' => 'Beginner', 'price' => 30.00, 'duration_days' => 30, 'description' => 'Basic monthly access for beginners.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intermediate', 'price' => 50.00, 'duration_days' => 60, 'description' => 'Extended access with better value.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Advanced', 'price' => 80.00, 'duration_days' => 90, 'description' => 'Advanced plan with training support.', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pro', 'price' => 120.00, 'duration_days' => 120, 'description' => 'Full access plan for pro athletes.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Create roles
        \App\Models\Role::insert([
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'trainer', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
