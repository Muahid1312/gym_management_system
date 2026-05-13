<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->foreignId('partner_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Disable foreign key constraints for SQLite
        DB::statement('PRAGMA foreign_keys = OFF');

        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['partner_id']);
        });

        // Re-enable foreign key constraints
        DB::statement('PRAGMA foreign_keys = ON');
    }
};
