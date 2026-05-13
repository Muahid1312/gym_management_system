<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diet_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('age');
            $table->decimal('weight', 8, 2); // kg
            $table->integer('height'); // cm
            $table->enum('goal', ['Fat Loss', 'Muscle Gain', 'General Fitness'])->default('General Fitness');
            $table->enum('level', ['Beginner', 'Intermediate', 'Advanced'])->default('Beginner');
            $table->json('plan_data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diet_plans');
    }
};
