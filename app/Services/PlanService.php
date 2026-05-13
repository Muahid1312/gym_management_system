<?php

namespace App\Services;

use App\Models\DietPlan;
use App\Models\Member;
use App\Models\WorkoutPlan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PlanService
{
    /**
     * Generate PDF combining workout and diet plans
     */
    public function generateCombinedPdf(Member $member): Response
    {
        $workoutPlan = $member->workoutPlans()->latest()->first();
        $dietPlan = $member->dietPlans()->latest()->first();

        if (!$workoutPlan || !$dietPlan) {
            throw new \Exception(__('messages.plan_requires_both'));
        }

        $data = [
            'member' => $member,
            'workoutPlan' => $workoutPlan,
            'dietPlan' => $dietPlan,
            'gymInfo' => \App\Models\GymInfo::getInstance(),
        ];

        $pdf = Pdf::loadView('plans.pdf-compact', $data)
            ->setPaper('a4')
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 5)
            ->setOption('margin-left', 10)
            ->setOption('margin-right', 10);

        return $pdf->download("plan_{$member->id}_{$member->name}.pdf");
    }

    /**
     * Generate professional PDF combining workout and diet plans
     */
    public function generateProfessionalPdf(Member $member): Response
    {
        $workoutPlan = $member->workoutPlans()->latest()->first();
        $dietPlan = $member->dietPlans()->latest()->first();

        if (!$workoutPlan || !$dietPlan) {
            throw new \Exception(__('messages.plan_requires_both'));
        }

        $data = [
            'member' => $member,
            'workoutPlan' => $workoutPlan,
            'dietPlan' => $dietPlan,
            'gymInfo' => \App\Models\GymInfo::getInstance(),
        ];

        $pdf = Pdf::loadView('plans.pdf-professional', $data)
            ->setPaper('a4')
            ->setOption('margin-top', '20mm')
            ->setOption('margin-bottom', '20mm')
            ->setOption('margin-left', '20mm')
            ->setOption('margin-right', '20mm');

        return $pdf->download("fitness_plan_{$member->id}_{$member->name}.pdf");
    }

    /**
     * Get latest plans for member
     */
    public function getLatestPlans(Member $member): array
    {
        return [
            'workout' => $member->workoutPlans()->latest()->first(),
            'diet' => $member->dietPlans()->latest()->first(),
        ];
    }

    /**
     * Calculate BMI
     */
    public function calculateBmi(float $weight, int $height): float
    {
        // height is in cm, convert to meters
        $heightInMeters = $height / 100;
        return round($weight / ($heightInMeters ** 2), 2);
    }

    /**
     * Get BMI category
     */
    public function getBmiCategory(float $bmi): string
    {
        if ($bmi < 18.5) {
            return __('messages.bmi_underweight');
        } elseif ($bmi < 25) {
            return __('messages.bmi_normal');
        } elseif ($bmi < 30) {
            return __('messages.bmi_overweight');
        } else {
            return __('messages.bmi_obese');
        }
    }

    /**
     * Format plan data for display
     */
    public function formatWorkoutPlanForDisplay(array $planData): array
    {
        $formatted = [];

        foreach ($planData as $day => $details) {
            if (is_array($details) && isset($details['exercises'])) {
                $formatted[$day] = [
                    'muscle_group' => $details['muscle_group'] ?? 'N/A',
                    'exercises' => $this->formatExercises($details['exercises'] ?? []),
                ];
            }
        }

        return $formatted;
    }

    /**
     * Format exercises for display
     */
    private function formatExercises(array $exercises): array
    {
        $formatted = [];

        foreach ($exercises as $exercise) {
            if (is_array($exercise)) {
                $formatted[] = [
                    'name' => $exercise['name'] ?? 'Unknown Exercise',
                    'sets' => $exercise['sets'] ?? 1,
                    'reps' => $exercise['reps'] ?? '8-12',
                    'notes' => $exercise['notes'] ?? '',
                ];
            }
        }

        return $formatted;
    }

    /**
     * Format diet plan for display
     */
    public function formatDietPlanForDisplay(array $planData): array
    {
        $formatted = [];
        $mealOrder = ['breakfast', 'lunch', 'dinner', 'snacks'];

        foreach ($mealOrder as $mealType) {
            if (isset($planData[$mealType])) {
                $meal = $planData[$mealType];
                $formatted[$mealType] = [
                    'name' => $meal['name'] ?? ucfirst($mealType),
                    'foods' => $meal['foods'] ?? [],
                    'macros' => $meal['macros'] ?? [],
                    'calories' => $meal['calories'] ?? 0,
                    'notes' => $meal['notes'] ?? '',
                ];
            }
        }

        return $formatted;
    }

    /**
     * Calculate daily macros from diet plan
     */
    public function calculateDailyMacros(array $dietPlan): array
    {
        $totals = [
            'protein' => 0,
            'carbs' => 0,
            'fats' => 0,
            'calories' => 0,
        ];

        foreach ($dietPlan as $meal) {
            if (is_array($meal)) {
                $macros = $meal['macros'] ?? [];
                $totals['protein'] += $macros['protein'] ?? 0;
                $totals['carbs'] += $macros['carbs'] ?? 0;
                $totals['fats'] += $macros['fats'] ?? 0;
                $totals['calories'] += $meal['calories'] ?? 0;
            }
        }

        return $totals;
    }
}
