<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\WorkoutPlan;
use App\Models\DietPlan;
use App\Services\AIService;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AIController extends Controller
{
    public function __construct(
        protected AIService $aiService,
        protected PlanService $planService
    ) {
    }

    /**
     * Show plan generation form
     */
    public function showGeneratePlanForm(Member $member): View
    {
        $member->load(['workoutPlans' => fn($q) => $q->latest(), 'dietPlans' => fn($q) => $q->latest()]);
        
        return view('plans.generate', [
            'member' => $member,
            'latestWorkout' => $member->workoutPlans->first(),
            'latestDiet' => $member->dietPlans->first(),
        ]);
    }

    /**
     * Generate workout plan
     */
    public function generateWorkoutPlan(Request $request, Member $member): RedirectResponse
    {
        $data = $request->validate([
            'age' => 'required|integer|min:13|max:120',
            'weight' => 'required|numeric|min:30|max:500',
            'height' => 'required|integer|min:120|max:250',
            'goal' => 'required|in:Fat Loss,Muscle Gain,General Fitness',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
        ]);

        try {
            // Generate workout plan using local rule-based templates
            $plan = $this->aiService->generateWorkoutPlan($data);
            
            // Save to database
            $this->aiService->saveWorkoutPlan($member->id, $data, $plan);

            return redirect()->route('ai.show-plans', $member)
                ->with('success', __('messages.workout_generated'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('messages.workout_generate_failed') . ' ' . $e->getMessage());
        }
    }

    /**
     * Generate diet plan
     */
    public function generateDietPlan(Request $request, Member $member): RedirectResponse
    {
        $data = $request->validate([
            'age' => 'required|integer|min:13|max:120',
            'weight' => 'required|numeric|min:30|max:500',
            'height' => 'required|integer|min:120|max:250',
            'goal' => 'required|in:Fat Loss,Muscle Gain,General Fitness',
            'level' => 'required|in:Beginner,Intermediate,Advanced',
        ]);

        try {
            // Generate diet plan using local rule-based templates
            $plan = $this->aiService->generateDietPlan($data);
            
            // Save to database
            $this->aiService->saveDietPlan($member->id, $data, $plan);

            return redirect()->route('ai.show-plans', $member)
                ->with('success', __('messages.diet_generated'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('messages.diet_generate_failed') . ' ' . $e->getMessage());
        }
    }

    /**
     * Show generated plans
     */
    public function showPlans(Member $member): View
    {
        $member->load([
            'workoutPlans' => fn($q) => $q->latest(),
            'dietPlans' => fn($q) => $q->latest(),
        ]);

        $workoutPlan = $member->workoutPlans->first();
        $dietPlan = $member->dietPlans->first();

        $formattedWorkout = null;
        $formattedDiet = null;

        if ($workoutPlan) {
            $formattedWorkout = $this->planService->formatWorkoutPlanForDisplay(
                $workoutPlan->plan_data ?? []
            );
        }

        if ($dietPlan) {
            $formattedDiet = $this->planService->formatDietPlanForDisplay(
                $dietPlan->plan_data ?? []
            );
            $dailyMacros = $this->planService->calculateDailyMacros($formattedDiet);
        }

        $bmi = null;
        $bmiCategory = null;
        if ($workoutPlan) {
            $bmi = $this->planService->calculateBmi($workoutPlan->weight, $workoutPlan->height);
            $bmiCategory = $this->planService->getBmiCategory($bmi);
        }

        return view('plans.show', [
            'member' => $member,
            'workoutPlan' => $workoutPlan,
            'dietPlan' => $dietPlan,
            'formattedWorkout' => $formattedWorkout,
            'formattedDiet' => $formattedDiet,
            'dailyMacros' => $dailyMacros ?? [],
            'bmi' => $bmi,
            'bmiCategory' => $bmiCategory,
        ]);
    }

    /**
     * Download combined PDF
     */
    public function downloadPdf(Member $member): Response
    {
        try {
            return $this->planService->generateCombinedPdf($member);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('messages.pdf_generate_failed') . ' ' . $e->getMessage());
        }
    }

    /**
     * Download professional PDF
     */
    public function downloadPdfProfessional(Member $member): Response
    {
        try {
            return $this->planService->generateProfessionalPdf($member);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('messages.pdf_generate_failed') . ' ' . $e->getMessage());
        }
    }

    /**
     * Print plans view
     */
    public function printPlans(Member $member): View
    {
        $member->load([
            'workoutPlans' => fn($q) => $q->latest(),
            'dietPlans' => fn($q) => $q->latest(),
        ]);

        $workoutPlan = $member->workoutPlans->first();
        $dietPlan = $member->dietPlans->first();

        $formattedWorkout = null;
        $formattedDiet = null;

        if ($workoutPlan) {
            $formattedWorkout = $this->planService->formatWorkoutPlanForDisplay(
                $workoutPlan->plan_data ?? []
            );
        }

        if ($dietPlan) {
            $formattedDiet = $this->planService->formatDietPlanForDisplay(
                $dietPlan->plan_data ?? []
            );
            $dailyMacros = $this->planService->calculateDailyMacros($formattedDiet);
        }

        $bmi = null;
        $bmiCategory = null;
        if ($workoutPlan) {
            $bmi = $this->planService->calculateBmi($workoutPlan->weight, $workoutPlan->height);
            $bmiCategory = $this->planService->getBmiCategory($bmi);
        }

        $gymInfo = \App\Models\GymInfo::getInstance();

        return view('plans.print', [
            'member' => $member,
            'workoutPlan' => $workoutPlan,
            'dietPlan' => $dietPlan,
            'formattedWorkout' => $formattedWorkout,
            'formattedDiet' => $formattedDiet,
            'dailyMacros' => $dailyMacros ?? [],
            'bmi' => $bmi,
            'bmiCategory' => $bmiCategory,
            'gymInfo' => $gymInfo,
        ]);
    }

    /**
     * Print compact plans view (1-page summary)
     */
    public function printPlansCompact(Member $member): View
    {
        $member->load([
            'workoutPlans' => fn($q) => $q->latest(),
            'dietPlans' => fn($q) => $q->latest(),
        ]);

        $workoutPlan = $member->workoutPlans->first();
        $dietPlan = $member->dietPlans->first();

        $formattedWorkout = null;
        $formattedDiet = null;

        if ($workoutPlan) {
            $formattedWorkout = $this->planService->formatWorkoutPlanForDisplay(
                $workoutPlan->plan_data ?? []
            );
        }

        if ($dietPlan) {
            $formattedDiet = $this->planService->formatDietPlanForDisplay(
                $dietPlan->plan_data ?? []
            );
            $dailyMacros = $this->planService->calculateDailyMacros($formattedDiet);
        }

        $bmi = null;
        $bmiCategory = null;
        if ($workoutPlan) {
            $bmi = $this->planService->calculateBmi($workoutPlan->weight, $workoutPlan->height);
            $bmiCategory = $this->planService->getBmiCategory($bmi);
        }

        $gymInfo = \App\Models\GymInfo::getInstance();

        return view('plans.print-compact', [
            'member' => $member,
            'workoutPlan' => $workoutPlan,
            'dietPlan' => $dietPlan,
            'formattedWorkout' => $formattedWorkout,
            'formattedDiet' => $formattedDiet,
            'dailyMacros' => $dailyMacros ?? [],
            'bmi' => $bmi,
            'bmiCategory' => $bmiCategory,
            'gymInfo' => $gymInfo,
        ]);
    }

    /**
     * Delete workout plan
     */
    public function deleteWorkoutPlan(WorkoutPlan $plan): RedirectResponse
    {
        $memberId = $plan->member_id;
        $plan->delete();

        return redirect()->route('ai.show-plans', $memberId)
            ->with('success', 'Workout plan deleted.');
    }

    /**
     * Delete diet plan
     */
    public function deleteDietPlan(DietPlan $plan): RedirectResponse
    {
        $memberId = $plan->member_id;
        $plan->delete();

        return redirect()->route('ai.show-plans', $memberId)
            ->with('success', 'Diet plan deleted.');
    }
}
