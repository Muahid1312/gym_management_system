<?php

namespace App\Services;

use App\Models\DietPlan;
use App\Models\WorkoutPlan;

// Local rule-based planner. This service generates workout and diet plans using built-in templates and business rules only.
class AIService
{
    public function generateWorkoutPlan(array $data): array
    {
        $goal = $data['goal'] ?? 'General Fitness';
        $level = $data['level'] ?? 'Beginner';
        $intensity = $this->getIntensityByLevel($level);

        $templates = $this->getWorkoutTemplates($goal, $level);
        $plan = [];

        foreach ($templates as $day => $template) {
            $plan[$day] = [
                'muscle_group' => $template['muscle_group'],
                'exercises' => [],
            ];

            foreach ($template['exercises'] as $exercise) {
                $plan[$day]['exercises'][] = [
                    'name' => $exercise['name'],
                    'sets' => $exercise['sets'] ?? $intensity['sets'],
                    'reps' => $exercise['reps'] ?? $intensity['reps'],
                    'notes' => $exercise['notes'] ?? $this->getExerciseNotes($exercise['name'], $goal, $level),
                ];
            }
        }

        return $plan;
    }

    public function generateDietPlan(array $data): array
    {
        $goal = $data['goal'] ?? 'General Fitness';
        $weight = $data['weight'] ?? 70;
        $height = $data['height'] ?? 170;

        $dailyCalories = $this->estimateCalories($weight, $goal);
        $macroRatios = $this->getMacroRatios($goal);

        $proteinGrams = (int) round(($dailyCalories * $macroRatios['protein']) / 4);
        $carbsGrams = (int) round(($dailyCalories * $macroRatios['carbs']) / 4);
        $fatsGrams = (int) round(($dailyCalories * $macroRatios['fats']) / 9);

        $meals = $this->getDietMealTemplates($goal, $weight);

        return [
            'breakfast' => array_merge($meals['breakfast'], [
                'macros' => [
                    'protein' => $this->roundMacro($proteinGrams * 0.25),
                    'carbs' => $this->roundMacro($carbsGrams * 0.28),
                    'fats' => $this->roundMacro($fatsGrams * 0.22),
                ],
                'calories' => (int) round($dailyCalories * 0.25),
            ]),
            'lunch' => array_merge($meals['lunch'], [
                'macros' => [
                    'protein' => $this->roundMacro($proteinGrams * 0.30),
                    'carbs' => $this->roundMacro($carbsGrams * 0.34),
                    'fats' => $this->roundMacro($fatsGrams * 0.28),
                ],
                'calories' => (int) round($dailyCalories * 0.34),
            ]),
            'dinner' => array_merge($meals['dinner'], [
                'macros' => [
                    'protein' => $this->roundMacro($proteinGrams * 0.27),
                    'carbs' => $this->roundMacro($carbsGrams * 0.26),
                    'fats' => $this->roundMacro($fatsGrams * 0.30),
                ],
                'calories' => (int) round($dailyCalories * 0.30),
            ]),
            'snacks' => array_merge($meals['snacks'], [
                'macros' => [
                    'protein' => $this->roundMacro($proteinGrams * 0.18),
                    'carbs' => $this->roundMacro($carbsGrams * 0.12),
                    'fats' => $this->roundMacro($fatsGrams * 0.20),
                ],
                'calories' => (int) round($dailyCalories * 0.11),
            ]),
        ];
    }

    public function saveWorkoutPlan(int $memberId, array $data, array $plan): WorkoutPlan
    {
        return WorkoutPlan::create([
            'member_id' => $memberId,
            'age' => $data['age'],
            'weight' => $data['weight'],
            'height' => $data['height'],
            'goal' => $data['goal'],
            'level' => $data['level'],
            'plan_data' => $plan,
        ]);
    }

    public function saveDietPlan(int $memberId, array $data, array $plan): DietPlan
    {
        return DietPlan::create([
            'member_id' => $memberId,
            'age' => $data['age'],
            'weight' => $data['weight'],
            'height' => $data['height'],
            'goal' => $data['goal'],
            'level' => $data['level'],
            'plan_data' => $plan,
        ]);
    }

    private function getIntensityByLevel(string $level): array
    {
        return match ($level) {
            'Advanced' => ['sets' => 4, 'reps' => '6-8'],
            'Intermediate' => ['sets' => 4, 'reps' => '8-10'],
            default => ['sets' => 3, 'reps' => '10-12'],
        };
    }

    private function getWorkoutTemplates(string $goal, string $level): array
    {
        return [
            'Day 1' => [
                'muscle_group' => 'Chest & Triceps',
                'exercises' => [
                    ['name' => 'Bench Press'],
                    ['name' => 'Incline Dumbbell Press'],
                    ['name' => 'Chest Flyes'],
                    ['name' => 'Tricep Dips'],
                ],
            ],
            'Day 2' => [
                'muscle_group' => 'Back & Biceps',
                'exercises' => [
                    ['name' => 'Pull-ups'],
                    ['name' => 'Bent-over Rows'],
                    ['name' => 'Lat Pulldown'],
                    ['name' => 'Bicep Curls'],
                ],
            ],
            'Day 3' => [
                'muscle_group' => 'Rest / Cardio',
                'exercises' => [
                    ['name' => 'Brisk Walking'],
                    ['name' => 'Cycling or Rowing'],
                ],
            ],
            'Day 4' => [
                'muscle_group' => 'Legs',
                'exercises' => [
                    ['name' => 'Squats'],
                    ['name' => 'Romanian Deadlifts'],
                    ['name' => 'Lunges'],
                    ['name' => 'Leg Press'],
                ],
            ],
            'Day 5' => [
                'muscle_group' => 'Shoulders & Core',
                'exercises' => [
                    ['name' => 'Overhead Press'],
                    ['name' => 'Lateral Raises'],
                    ['name' => 'Plank'],
                    ['name' => 'Russian Twists'],
                ],
            ],
            'Day 6' => [
                'muscle_group' => 'Full Body',
                'exercises' => [
                    ['name' => 'Deadlifts'],
                    ['name' => 'Push-ups'],
                    ['name' => 'Dumbbell Rows'],
                    ['name' => 'Goblet Squats'],
                ],
            ],
            'Day 7' => [
                'muscle_group' => 'Recovery',
                'exercises' => [
                    ['name' => 'Stretching Routine'],
                    ['name' => 'Light Mobility'],
                ],
            ],
        ];
    }

    private function getExerciseNotes(string $name, string $goal, string $level): string
    {
        $goalNotes = [
            'Fat Loss' => 'Keep rest periods short and stay active between sets.',
            'Muscle Gain' => 'Focus on progressive overload and controlled form.',
            'General Fitness' => 'Maintain steady pace and good technique.',
        ];

        return $goalNotes[$goal] ?? 'Perform the movement with control and proper form.';
    }

    private function estimateCalories(float $weight, string $goal): int
    {
        $base = (int) round($weight * 24);

        return match ($goal) {
            'Fat Loss' => max(1200, $base - 300),
            'Muscle Gain' => $base + 300,
            default => $base,
        };
    }

    private function getMacroRatios(string $goal): array
    {
        return match ($goal) {
            'Fat Loss' => ['protein' => 0.35, 'carbs' => 0.40, 'fats' => 0.25],
            'Muscle Gain' => ['protein' => 0.30, 'carbs' => 0.50, 'fats' => 0.20],
            default => ['protein' => 0.30, 'carbs' => 0.40, 'fats' => 0.30],
        };
    }

    private function getDietMealTemplates(string $goal, float $weight): array
    {
        $common = [
            'Fat Loss' => [
                'breakfast' => [
                    'name' => 'Egg White Omelette with Vegetables',
                    'foods' => ['Egg whites', 'Spinach', 'Tomato', 'Mushrooms'],
                    'notes' => 'Cook with minimal oil to keep calories low.',
                ],
                'lunch' => [
                    'name' => 'Grilled Chicken Salad',
                    'foods' => ['Chicken breast', 'Mixed greens', 'Cucumber', 'Olive oil'],
                    'notes' => 'Use a light dressing and add lemon juice.',
                ],
                'dinner' => [
                    'name' => 'Baked Fish with Steamed Vegetables',
                    'foods' => ['White fish', 'Broccoli', 'Carrots', 'Zucchini'],
                    'notes' => 'Season with herbs and bake with lemon.',
                ],
                'snacks' => [
                    'name' => 'Greek Yogurt with Berries',
                    'foods' => ['Greek yogurt', 'Strawberries', 'Almonds'],
                    'notes' => 'Choose plain yogurt and add fresh berries.',
                ],
            ],
            'Muscle Gain' => [
                'breakfast' => [
                    'name' => 'Oatmeal with Banana and Eggs',
                    'foods' => ['Oats', 'Banana', 'Whole eggs', 'Honey'],
                    'notes' => 'Add a scoop of protein powder if available.',
                ],
                'lunch' => [
                    'name' => 'Rice, Chicken and Vegetables',
                    'foods' => ['White rice', 'Chicken breast', 'Broccoli', 'Olive oil'],
                    'notes' => 'Include extra rice for carb support.',
                ],
                'dinner' => [
                    'name' => 'Salmon with Sweet Potato',
                    'foods' => ['Salmon', 'Sweet potato', 'Green beans'],
                    'notes' => 'Use healthy fats and simple seasoning.',
                ],
                'snacks' => [
                    'name' => 'Peanut Butter Banana Shake',
                    'foods' => ['Banana', 'Peanut butter', 'Milk', 'Oats'],
                    'notes' => 'Blend together for a calorie-dense snack.',
                ],
            ],
            'General Fitness' => [
                'breakfast' => [
                    'name' => 'Whole Grain Toast with Avocado',
                    'foods' => ['Whole grain bread', 'Avocado', 'Eggs'],
                    'notes' => 'Balanced carbs, healthy fats, and protein.',
                ],
                'lunch' => [
                    'name' => 'Turkey Sandwich and Salad',
                    'foods' => ['Whole grain bread', 'Turkey', 'Lettuce', 'Tomato'],
                    'notes' => 'Keep portions moderate and nutrient-dense.',
                ],
                'dinner' => [
                    'name' => 'Stir-Fry Chicken and Rice',
                    'foods' => ['Chicken', 'Vegetables', 'Brown rice'],
                    'notes' => 'Use a light sauce and plenty of vegetables.',
                ],
                'snacks' => [
                    'name' => 'Mixed Nuts and Fruit',
                    'foods' => ['Almonds', 'Walnuts', 'Apple slices'],
                    'notes' => 'Choose whole foods for lasting energy.',
                ],
            ],
        ];

        return $common[$goal] ?? $common['General Fitness'];
    }

    private function roundMacro(float $value): int
    {
        return max(0, (int) round($value));
    }
}
