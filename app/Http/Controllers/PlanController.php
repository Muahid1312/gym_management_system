<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return view('plans.index', [
            'plans' => Plan::orderBy('duration_days')->get(),
        ]);
    }

    public function create()
    {
        return view('plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:plans,name',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        Plan::create($data);

        return redirect()->route('plans.index')->with('success', 'Membership plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        return view('plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:plans,name,' . $plan->id,
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
        ]);

        $plan->update($data);

        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }
}
