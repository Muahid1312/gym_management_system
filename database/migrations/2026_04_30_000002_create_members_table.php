<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->foreignId('plan_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->date('join_date');
            $table->date('expiry_date');
            $table->string('workout_level')->default('beginner');
            $table->string('diet_level')->default('beginner');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
