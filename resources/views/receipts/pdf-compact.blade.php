<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    @php
        include_once app_path('Support/persian_pdf_helpers.php');
    @endphp
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: 'Vazir';
            font-style: normal;
            font-weight: 400;
            src: url("{{ public_path('fonts/Vazir-Regular.ttf') }}") format('truetype');
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            direction: ltr;
            color: #000;
            background: white;
            width: 80mm;
            margin: 0 auto;
            padding: 0;
        }

        .receipt-container {
            width: 80mm;
            margin: 0 auto;
            padding: 8mm;
            background: white;
            line-height: 1.2;
        }

        /* Header - Logo and Gym Name */
        .header {
            text-align: center;
            margin-bottom: 6mm;
            border-bottom: 1px solid #000;
            padding-bottom: 4mm;
        }

        .logo {
            margin-bottom: 3mm;
        }

        .logo img {
            width: 40mm;
            height: auto;
            max-height: 30mm;
        }

        .gym-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 2mm;
        }

        .gym-contact {
            font-size: 8px;
            line-height: 1.4;
        }

        .gym-contact-line {
            margin: 1mm 0;
        }

        /* Divider */
        .divider {
            border-top: 1px solid #000;
            margin: 3mm 0;
        }

        .divider-double {
            border-top: 2px solid #000;
            margin: 3mm 0;
        }

        /* Receipt Number */
        .receipt-number {
            text-align: center;
            font-weight: bold;
            font-size: 9px;
            margin-bottom: 4mm;
            padding: 2mm 0;
            background: #f9f9f9;
            border: 1px solid #ddd;
        }

        /* Section Titles */
        .section-title {
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            margin: 3mm 0 2mm 0;
            border-bottom: 1px solid #000;
            padding-bottom: 1mm;
        }

        /* Info Rows */
        .kv-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            line-height: 1.3;
        }
        .kv-table td {
            padding: 0.6mm 0;
            vertical-align: top;
        }
        .info-label {
            font-weight: bold;
            width: 40%;
        }
        .info-value {
            width: 60%;
            text-align: right;
            word-break: break-word;
        }
        /* Shaped Persian (persian_pdf_shape): visual LTR glyph stream */
        span.persian {
            font-family: "Vazir", sans-serif;
            font-weight: 400;
            font-style: normal;
            direction: ltr;
            unicode-bidi: isolate;
            display: inline-block;
            line-height: 1.45;
            text-align: right;
        }

        /* Payment Details Section */
        .amount-section {
            background: #f9f9f9;
            padding: 3mm;
            margin: 3mm 0;
            border: 1px solid #ddd;
        }

        .amount-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            font-weight: bold;
        }
        .amount-table td {
            padding: 0.8mm 0;
            vertical-align: top;
        }
        .amount-label {
            width: 55%;
        }
        .amount-value {
            width: 45%;
            text-align: right;
            white-space: nowrap;
        }
        .amount-table .total td {
            font-size: 11px;
            border-top: 1px solid #000;
            padding-top: 2mm;
        }

        /* Balance Warning */
        .balance-remaining {
            font-size: 9px;
            margin: 2mm 0;
            padding: 2mm;
            background: #fffacd;
            border-left: 3px solid #ff9800;
        }

        .balance-remaining strong {
            font-weight: bold;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 4mm;
            padding-top: 3mm;
            border-top: 1px solid #000;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .thank-you {
            margin-bottom: 2mm;
        }

        .date-time {
            font-size: 8px;
            color: #666;
            margin-top: 2mm;
            font-weight: normal;
        }

        /* Print Styles */
        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
            }

            .receipt-container {
                padding: 8mm;
                margin: 0;
            }
        }

        /* Avoid page breaks */
        .receipt-container {
            page-break-inside: avoid;
        }

        .divider-dots {
            text-align: center;
            letter-spacing: 2px;
            font-size: 9px;
            margin: 2mm 0;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header: Logo and Gym Info -->
        <div class="header">
            @if($gymLogoUrl)
                <div class="logo">
                    <img src="{{ $gymLogoUrl }}" alt="Gym Logo">
                </div>
            @endif

            <div class="gym-name">{{ $gymName }}</div>

            <div class="gym-contact">
                @if($gymAddress)
                    <div class="gym-contact-line">{{ $gymAddress }}</div>
                @endif
                @if($gymPhone)
                    <div class="gym-contact-line">{{ $gymPhone }}</div>
                @endif
                @if($gymEmail)
                    <div class="gym-contact-line">{{ $gymEmail }}</div>
                @endif
            </div>
        </div>

        <!-- Receipt Number -->
        <div class="receipt-number">
            Receipt #{{ $receipt->receipt_number }}
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Member Information -->
        <div class="section-title">Member</div>
        <table class="kv-table" role="presentation">
            <tr>
                <td class="info-label">Name:</td>
                <td class="info-value"><span class="persian" dir="ltr" lang="fa">{{ persian_pdf_shape($member->name) }}</span></td>
            </tr>
            <tr>
                <td class="info-label">Phone:</td>
                <td class="info-value">{{ $member->phone }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Payment Information -->
        <div class="section-title">Payment Details</div>

        <table class="kv-table" role="presentation">
            <tr>
                <td class="info-label">Plan:</td>
                <td class="info-value">{{ $payment->plan->name }}</td>
            </tr>
            <tr>
                <td class="info-label">Date:</td>
                <td class="info-value">{{ $receipt->created_at->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td class="info-label">Time:</td>
                <td class="info-value">{{ $receipt->created_at->format('H:i A') }}</td>
            </tr>
            <tr>
                <td class="info-label">Method:</td>
                <td class="info-value" style="text-transform: capitalize;">{{ $receipt->payment_method }}</td>
            </tr>
        </table>

        <!-- Amount Section -->
        <div class="divider"></div>

        <div class="amount-section">
            <table class="amount-table" role="presentation">
                <tr>
                    <td class="amount-label">Amount Paid:</td>
                    <td class="amount-value">${{ number_format($receipt->amount_paid, 2) }}</td>
                </tr>
                <tr>
                    <td class="amount-label">Balance:</td>
                    <td class="amount-value">${{ number_format($receipt->remaining_balance, 2) }}</td>
                </tr>
                <tr class="total">
                    <td class="amount-label">Total Due:</td>
                    <td class="amount-value">${{ number_format($receipt->remaining_balance, 2) }}</td>
                </tr>
            </table>
        </div>

        <!-- Balance Status -->
        @if($receipt->remaining_balance > 0)
            <div class="balance-remaining">
                <strong>⚠ Balance Due:</strong><br>
                You have ${{ number_format($receipt->remaining_balance, 2) }} remaining
            </div>
        @else
            <div class="balance-remaining" style="background: #e8f5e9; border-left-color: #4caf50;">
                <strong>✓ Paid in Full</strong><br>
                Thank you for your payment!
            </div>
        @endif

        <!-- Footer -->
        <div class="divider-double"></div>

        <div class="footer">
            <div class="thank-you">THANK YOU!</div>
            <div class="divider-dots">. . . . . . . . . . .</div>
            <div class="date-time">{{ now()->format('Y-m-d H:i:s') }}</div>
        </div>
    </div>
</body>
</html>
