<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Print - {{ $receipt->receipt_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .receipt-container {
            width: 300px;
            background: white;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            font-size: 12px;
            line-height: 1.4;
        }

        /* Header */
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .gym-logo {
            max-width: 60px;
            height: auto;
            margin-bottom: 8px;
        }

        .gym-name {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin: 8px 0 4px 0;
        }

        .gym-contact {
            font-size: 10px;
            color: #333;
            line-height: 1.3;
        }

        /* Receipt Info */
        .receipt-info {
            margin: 15px 0;
            padding: 10px;
            background: #f9f9f9;
            border-left: 3px solid #000;
        }

        .receipt-number {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .receipt-date {
            font-size: 10px;
            color: #666;
        }

        /* Divider */
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        /* Member Info */
        .section-title {
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            margin-top: 10px;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 4px 0;
            font-size: 11px;
        }

        .info-label {
            font-weight: 600;
            color: #333;
        }

        .info-value {
            text-align: right;
            color: #555;
        }

        /* Amount Section */
        .amount-section {
            margin-top: 15px;
            padding: 10px;
            background: #f0f0f0;
            border: 1px solid #ddd;
        }

        .amount-row {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
            font-size: 11px;
        }

        .amount-row.total {
            font-weight: bold;
            font-size: 12px;
            border-top: 1px solid #000;
            padding-top: 4px;
            margin-top: 8px;
        }

        .amount-row.balance {
            color: #d32f2f;
            font-weight: 600;
        }

        .amount-label {
            text-align: left;
        }

        .amount-value {
            text-align: right;
            min-width: 80px;
        }

        /* Footer */
        .receipt-footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
        }

        .thank-you {
            font-weight: 600;
            margin-bottom: 4px;
            color: #000;
        }

        .footer-text {
            line-height: 1.6;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .receipt-container {
                width: 300px;
                margin: 0 auto;
                box-shadow: none;
                border: none;
                padding: 10px;
                page-break-after: always;
            }

            .no-print {
                display: none !important;
            }

            .print-btn {
                display: none;
            }
        }

        /* Print Button */
        .print-btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 20px auto 0;
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }

        .print-btn:hover {
            background: #1a252f;
        }

        /* Responsive */
        @media (max-width: 400px) {
            body {
                padding: 10px;
            }

            .receipt-container {
                width: 100%;
                max-width: 300px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="receipt-header">
            @php
                $gymInfo = \App\Models\GymInfo::first();
            @endphp

            @if($gymInfo && $gymInfo->logo_path)
                <img src="{{ $gymInfo->getLogoUrl() }}" alt="Logo" class="gym-logo">
            @endif

            <div class="gym-name">{{ $gymInfo?->gym_name ?? 'GYM MANAGEMENT SYSTEM' }}</div>
            <div class="gym-contact">
                @if($gymInfo?->phone)
                    {{ $gymInfo->phone }}<br>
                @endif
                @if($gymInfo?->email)
                    {{ $gymInfo->email }}
                @endif
            </div>
        </div>

        <!-- Receipt Info -->
        <div class="receipt-info">
            <div class="receipt-number">Receipt #{{ $receipt->receipt_number }}</div>
            <div class="receipt-date">Date: {{ $receipt->created_at->format('M d, Y H:i') }}</div>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Member Information -->
        <div class="section-title">Member</div>
        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value">{{ $receipt->member->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone:</span>
            <span class="info-value">{{ $receipt->member->phone }}</span>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Payment Information -->
        <div class="section-title">Payment Details</div>
        <div class="info-row">
            <span class="info-label">Method:</span>
            <span class="info-value">{{ ucfirst($receipt->payment_method) }}</span>
        </div>
        @if($receipt->payment?->plan)
        <div class="info-row">
            <span class="info-label">Plan:</span>
            <span class="info-value">{{ $receipt->payment->plan->name }}</span>
        </div>
        @endif

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Amount Section -->
        <div class="amount-section">
            <div class="amount-row">
                <span class="amount-label">Amount Paid:</span>
                <span class="amount-value">${{ number_format($receipt->amount_paid, 2) }}</span>
            </div>
            <div class="amount-row balance">
                <span class="amount-label">Balance:</span>
                <span class="amount-value">${{ number_format($receipt->remaining_balance, 2) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="receipt-footer">
            <div class="thank-you">Thank You!</div>
            <div class="footer-text">
                For more information, visit our gym.<br>
                Keep this receipt for your records.
            </div>
        </div>
    </div>

    <button class="print-btn no-print" onclick="window.print()">🖨️ Print Receipt</button>

    <script>
        // Auto print on page load (optional - uncomment to enable)
        // window.addEventListener('load', function() {
        //     window.print();
        // });
    </script>
</body>
</html>