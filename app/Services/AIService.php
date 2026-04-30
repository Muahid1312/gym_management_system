<?php

namespace App\Services;

use App\Models\DietPlan;
use App\Models\WorkoutPlan;

class AIService
{
    public function generateWorkoutPlan(array $data): array
    {
        // Simulate AI generation (replace with real API call)
        $plan = [
            'Day 1' => 'Chest + Triceps: Push-ups, Tricep dips',
            'Day 2' => 'Back + Biceps: Pull-ups, Bicep curls',
            // etc.
        ];
        return $plan;
    }

    public function generateDietPlan(array $data): array
    {
        // Simulate AI generation
        $plan = [
            'Breakfast' => 'Oatmeal with fruits',
            'Lunch' => 'Grilled chicken salad',
            // etc.
        ];
        return $plan;
    }

    public function saveWorkoutPlan(int $memberId, string $level, array $plan): WorkoutPlan
    {
        return WorkoutPlan::create([
            'member_id' => $memberId,
            'level' => $level,
            'plan_data' => $plan,
        ]);
    }

    public function saveDietPlan(int $memberId, string $level, array $plan): DietPlan
    {
        return DietPlan::create([
            'member_id' => $memberId,
            'level' => $level,
            'plan_data' => $plan,
        ]);
    }
}
