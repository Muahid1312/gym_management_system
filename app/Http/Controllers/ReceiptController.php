<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Services\ReceiptService;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function __construct(protected ReceiptService $receiptService)
    {
    }

    /**
     * List all receipts
     */
    public function index()
    {
        $receipts = Receipt::with(['member', 'payment'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('receipts.index', compact('receipts'));
    }

    /**
     * Show receipt details
     */
    public function show(Receipt $receipt)
    {
        $receipt->load(['member', 'payment', 'payment.plan']);

        return view('receipts.show', compact('receipt'));
    }

    /**
     * Download receipt as PDF
     */
    public function download(Receipt $receipt)
    {
        return $this->receiptService->generatePdf($receipt);
    }

    /**
     * View receipt as PDF (inline)
     */
    public function view(Receipt $receipt)
    {
        return $this->receiptService->viewPdf($receipt);
    }

    /**
     * Print receipt (POS style)
     */
    public function print(Receipt $receipt)
    {
        $receipt->load(['member', 'payment', 'payment.plan']);

        return view('receipts.print', compact('receipt'));
    }

    /**
     * Download receipt by payment
     */
    public function downloadByPayment($paymentId)
    {
        $receipt = Receipt::where('payment_id', $paymentId)->firstOrFail();

        return $this->receiptService->generatePdf($receipt);
    }
}
