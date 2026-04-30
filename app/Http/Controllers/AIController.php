<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\AIService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    public function __construct(protected AIService $aiService)
    {
    }

    public function generateWorkoutPlan(Request $request, Member $member)
    {
        $data = $request->validate([
            'age' => 'required|integer',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'goal' => 'required|string',
            'level' => 'required|string',
        ]);

        $plan = $this->aiService->generateWorkoutPlan($data);
        $this->aiService->saveWorkoutPlan($member->id, $data['level'], $plan);

        return redirect()->back()->with('success', 'Workout plan generated.');
    }

    public function generateDietPlan(Request $request, Member $member)
    {
        $data = $request->validate([
            'age' => 'required|integer',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'goal' => 'required|string',
            'level' => 'required|string',
        ]);

        $plan = $this->aiService->generateDietPlan($data);
        $this->aiService->saveDietPlan($member->id, $data['level'], $plan);

        return redirect()->back()->with('success', 'Diet plan generated.');
    }
}
