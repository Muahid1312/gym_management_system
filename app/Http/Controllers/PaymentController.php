<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Plan;
use App\Models\Partner;
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
            'payments' => Payment::with(['member', 'plan', 'partner'])->orderByDesc('paid_at')->get(),
        ]);
    }

    public function create()
    {
        return view('payments.create', [
            'members' => Member::orderBy('name')->get(),
            'plans' => Plan::orderBy('name')->get(),
            'partners' => Partner::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|exists:members,id',
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0',
            'paid_at' => 'required|date',
            'payment_method' => 'required|in:cash,online',
            'partner_id' => 'nullable|exists:partners,id',
            'notes' => 'nullable|string|max:1000',
            'is_partial' => 'boolean',
        ]);

        $member = Member::findOrFail($data['member_id']);
        $plan = Plan::findOrFail($data['plan_id']);

        $payment = $this->paymentService->processPayment(
            member: $member,
            plan: $plan,
            amount: $data['amount'],
            isPartial: $data['is_partial'] ?? false,
            partnerId: $data['partner_id'] ?? null,
            paymentMethod: $data['payment_method'],
            notes: $data['notes'] ?? null
        );

        return redirect()->route('receipts.show', $payment->receipt)
            ->with('success', 'Payment recorded successfully. Receipt has been generated.');
    }
}

