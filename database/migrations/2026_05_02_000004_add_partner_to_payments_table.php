<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('partner_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->enum('payment_method', ['cash', 'online'])
                ->default('cash')
                ->after('paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['partner_id']);
            $table->dropColumn(['partner_id', 'payment_method']);
        });
    }
};
