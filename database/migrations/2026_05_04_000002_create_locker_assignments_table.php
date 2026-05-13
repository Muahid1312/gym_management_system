<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locker_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('locker_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->dateTime('assigned_at')->default(now());
            $table->date('expiry_date')->nullable();
            $table->boolean('temporary')->default(false);
            $table->dateTime('returned_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locker_assignments');
    }
};
