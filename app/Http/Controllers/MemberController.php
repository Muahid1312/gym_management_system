<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Plan;
use App\Services\RiskDetectionService;
use App\Services\FinancialReportService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct(
        private RiskDetectionService $riskService,
        private FinancialReportService $financialService
    ) {}

    public function index(Request $request)
    {
        $query = Member::with('plan');

        // Search by name or phone
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        $filter = $request->input('filter', 'all');
        match ($filter) {
            'active' => $query->where('expiry_date', '>=', now()->toDateString()),
            'expired' => $query->where('expiry_date', '<', now()->toDateString()),
            'expiring_soon' => $query->whereBetween('expiry_date', [
                now()->toDateString(),
                now()->addDays(3)->toDateString(),
            ]),
            'in_debt' => $query->where('debt', '>', 0),
            default => null,
        };

        $members = $query->orderBy('name')->get();
        $viewMode = $request->input('view_mode', 'dropdown');

        return view($viewMode === 'modal' ? 'members.index-modal' : 'members.index', [
            'members' => $members,
            'filter' => $filter,
            'search' => $request->input('search'),
            'viewMode' => $viewMode,
        ]);
    }

    /**
     * Show member profile with detailed information.
     */
    public function show(Member $member)
    {
        $member->load(['plan', 'payments', 'attendances', 'workoutPlans', 'dietPlans', 'lockerAssignment.locker']);

        $paymentStats = $this->financialService->getMemberPaymentStats($member->id);
        $daysUntilExpiry = $this->riskService->getDaysUntilExpiry($member);
        $isAtRisk = $this->riskService->isAtRisk($member);

        return view('members.show', [
            'member' => $member,
            'paymentStats' => $paymentStats,
            'daysUntilExpiry' => $daysUntilExpiry,
            'isAtRisk' => $isAtRisk,
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
            'email' => 'required|string|max:255',
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
            'email' => 'required|string|max:255',
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
