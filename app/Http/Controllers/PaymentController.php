<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Plan;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {
    }
    public function index()
    {
        return view('payments.index', [
            'payments' => Payment::with(['member', 'plan'])->orderByDesc('paid_at')->get(),
        ]);
    }

    public function create()
    {
        return view('payments.create', [
            'members' => Member::orderBy('name')->get(),
            'plans' => Plan::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'is_partial' => 'boolean',
        ]);

        $member = Member::findOrFail($data['member_id']);
        $plan = Plan::findOrFail($data['plan_id']);

        $this->paymentService->processPayment($member, $plan, $data['amount'], $data['is_partial'] ?? false);

        return redirect()->route('payments.index')->with('success', 'Payment recorded and debt updated.');
    }
}
