<?php

namespace App\Services;

use App\Models\GymInfo;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ReceiptService
{
    /**
     * Generate a unique receipt number
     */
    public function generateReceiptNumber(): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $latestReceipt = Receipt::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest('id')
            ->first();

        $sequence = 1;
        if ($latestReceipt) {
            // Extract sequence number from receipt number (e.g., "RCP-2026-05-00001" -> "00001")
            $parts = explode('-', $latestReceipt->receipt_number);
            if (count($parts) >= 4) {
                $sequence = intval($parts[3]) + 1;
            }
        }

        return sprintf('RCP-%d-%02d-%05d', $year, $month, $sequence);
    }

    /**
     * Create a receipt for a payment
     */
    public function createReceipt(
        Payment $payment,
        string $paymentMethod = 'cash',
        string $notes = null
    ): Receipt {
        $member = $payment->member;

        // Calculate remaining balance
        $remainingBalance = max(0, $member->debt);

        $receipt = Receipt::create([
            'receipt_number' => $this->generateReceiptNumber(),
            'member_id' => $member->id,
            'payment_id' => $payment->id,
            'amount_paid' => $payment->amount,
            'remaining_balance' => $remainingBalance,
            'payment_method' => $paymentMethod,
            'notes' => $notes,
        ]);

        return $receipt;
    }

    /**
     * Get gym information data
     */
    private function getGymData(): array
    {
        $gymInfo = GymInfo::getInstance();

        return [
            'gym_name' => $gymInfo->gym_name,
            'gym_phone' => $gymInfo->phone,
            'gym_email' => $gymInfo->email,
            'gym_address' => $gymInfo->address,
            'gym_logo_url' => $gymInfo->hasLogo() ? $gymInfo->getLogoUrl() : null,
        ];
    }

    /**
     * Generate PDF for a receipt
     */
    public function generatePdf(Receipt $receipt): \Illuminate\Http\Response
    {
        $receipt->load(['member', 'payment', 'payment.plan']);

        $gymData = $this->getGymData();

        $data = [
            'receipt' => $receipt,
            'member' => $receipt->member,
            'payment' => $receipt->payment,
            'gymName' => $gymData['gym_name'],
            'gymPhone' => $gymData['gym_phone'],
            'gymEmail' => $gymData['gym_email'],
            'gymAddress' => $gymData['gym_address'],
            'gymLogoUrl' => $gymData['gym_logo_url'],
        ];

        $pdf = Pdf::loadView('receipts.pdf-compact', $data);

        return $pdf->download('Receipt-' . $receipt->receipt_number . '.pdf');
    }

    /**
     * View receipt as PDF (inline)
     */
    public function viewPdf(Receipt $receipt)
    {
        $receipt->load(['member', 'payment', 'payment.plan']);

        $gymData = $this->getGymData();

        $data = [
            'receipt' => $receipt,
            'member' => $receipt->member,
            'payment' => $receipt->payment,
            'gymName' => $gymData['gym_name'],
            'gymPhone' => $gymData['gym_phone'],
            'gymEmail' => $gymData['gym_email'],
            'gymAddress' => $gymData['gym_address'],
            'gymLogoUrl' => $gymData['gym_logo_url'],
        ];

        $pdf = Pdf::loadView('receipts.pdf-compact', $data);

        return $pdf->stream('Receipt-' . $receipt->receipt_number . '.pdf');
    }
}
