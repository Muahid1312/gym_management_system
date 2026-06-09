<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            margin: 24px;
        }

        /* Static Vazir: variable fonts (e.g. Vazirmatn-VF) often render incorrectly in DomPDF */
        @font-face {
            font-family: 'Vazir';
            font-style: normal;
            font-weight: 400;
            src: url("{{ public_path('fonts/Vazir-Regular.ttf') }}") format('truetype');
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            direction: ltr;
            color: #333;
            background: white;
        }
        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            background: white;
            border: 1px solid #ddd;
        }
        .header {
            text-align: left;
            border-bottom: 2px solid #f97316;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .gym-info {
            font-weight: bold;
            font-size: 18px;
            color: #f97316;
            margin-bottom: 10px;
        }
        .gym-details {
            font-size: 12px;
            color: #666;
            line-height: 1.6;
            text-align: left;
        }
        .receipt-number {
            text-align: center;
            background: #f5f5f5;
            padding: 10px;
            margin: 20px 0;
            font-weight: bold;
            border-radius: 4px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-weight: bold;
            color: #f97316;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
            margin-bottom: 12px;
            font-size: 13px;
            text-transform: uppercase;
        }
        .kv-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .kv-table tr {
            page-break-inside: avoid;
        }
        .kv-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            color: #333;
            width: 34%;
        }
        .value {
            color: #666;
            width: 66%;
            text-align: right;
            word-break: break-word;
        }
        /* Shaped Persian (persian_pdf_shape): visual LTR glyph stream; do not use RTL here */
        .value-persian {
            font-family: "Vazir", sans-serif;
            font-weight: 400;
            font-style: normal;
            direction: ltr;
            unicode-bidi: isolate;
            text-align: right;
            display: inline-block;
            line-height: 1.45;
        }
        .amount-section {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
        .amount-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .amount-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .amount-table .amount-label {
            width: 60%;
            color: #333;
        }
        .amount-table .amount-value {
            width: 40%;
            text-align: right;
            color: #666;
            white-space: nowrap;
        }
        .amount-table .total td {
            font-weight: bold;
            color: #f97316;
            font-size: 16px;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #999;
            font-size: 12px;
        }
        .balance-warning {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 12px;
            border-radius: 4px;
            margin: 10px 0;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <div class="gym-info">{{ $gymName }}</div>
            <div class="gym-details">
                <div>{{ $gymAddress }}</div>
                <div>{{ $gymPhone }}</div>
                <div>{{ $gymEmail }}</div>
            </div>
        </div>

        <!-- Receipt Number -->
        <div class="receipt-number">
            Receipt #{{ $receipt->receipt_number }}
        </div>

        <!-- Member Information -->
        <div class="section">
            <div class="section-title">Member Information</div>
            <table class="kv-table" role="presentation">
                <tr>
                    <td class="label">Name:</td>
                    <td class="value">
                        <span class="value-persian" dir="ltr" lang="fa">{{ persian_pdf_shape($member->name) }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Email:</td>
                    <td class="value">{{ $member->email }}</td>
                </tr>
                <tr>
                    <td class="label">Phone:</td>
                    <td class="value">{{ $member->phone }}</td>
                </tr>
                <tr>
                    <td class="label">Plan:</td>
                    <td class="value">{{ $payment->plan->name }}</td>
                </tr>
            </table>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <div class="section-title">Payment Details</div>
            <table class="kv-table" role="presentation">
                <tr>
                    <td class="label">Date:</td>
                    <td class="value">{{ $receipt->created_at->format('M d, Y H:i A') }}</td>
                </tr>
                <tr>
                    <td class="label">Method:</td>
                    <td class="value" style="text-transform: capitalize;">{{ $receipt->payment_method }}</td>
                </tr>
                @if($receipt->notes)
                    <tr>
                        <td class="label">Notes:</td>
                        <td class="value">{{ $receipt->notes }}</td>
                    </tr>
                @endif
            </table>
        </div>

        <!-- Amount Section -->
        <div class="amount-section">
            <table class="amount-table" role="presentation">
                <tr>
                    <td class="amount-label">Amount Paid:</td>
                    <td class="amount-value">${{ number_format($receipt->amount_paid, 2) }}</td>
                </tr>
                <tr class="total">
                    <td class="amount-label">Remaining Balance:</td>
                    <td class="amount-value">${{ number_format($receipt->remaining_balance, 2) }}</td>
                </tr>
            </table>
        </div>

        @if($receipt->remaining_balance > 0)
        <div class="balance-warning">
            Outstanding balance remaining. Please contact the gym for payment schedule.
        </div>
        @else
        <div class="balance-warning" style="background: #d4edda; border-color: #28a745; color: #155724;">
            ✓ All payments are current.
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is an automated receipt. For inquiries, contact {{ $gymEmail }}</p>
            <p>Generated on {{ now()->format('M d, Y H:i A') }}</p>
        </div>
    </div>
</body>
</html>
