<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Plan;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view('members.index', [
            'members' => Member::with('plan')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('members.create', [
            'plans' => Plan::orderBy('name')->get(),
            'levels' => ['beginner', 'intermediate', 'advanced', 'pro'],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'photo' => 'nullable|image|max:2048',
            'plan_id' => 'required|exists:plans,id',
            'join_date' => 'required|date',
            'workout_level' => 'required|in:beginner,intermediate,advanced,pro',
            'diet_level' => 'required|in:beginner,intermediate,advanced,pro',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);
        $expiryDate = now()->parse($data['join_date'])->addDays($plan->duration_days)->toDateString();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        Member::create(array_merge($data, ['expiry_date' => $expiryDate, 'debt' => $plan->price]));

        return redirect()->route('members.index')->with('success', 'Member registered successfully.');
    }

    public function edit(Member $member)
    {
        return view('members.edit', [
            'member' => $member,
            'plans' => Plan::orderBy('name')->get(),
            'levels' => ['beginner', 'intermediate', 'advanced', 'pro'],
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'photo' => 'nullable|image|max:2048',
            'plan_id' => 'required|exists:plans,id',
            'join_date' => 'required|date',
            'workout_level' => 'required|in:beginner,intermediate,advanced,pro',
            'diet_level' => 'required|in:beginner,intermediate,advanced,pro',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);
        $data['expiry_date'] = now()->parse($data['join_date'])->addDays($plan->duration_days)->toDateString();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Member details updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member removed successfully.');
    }
}
