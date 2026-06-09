<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            size: 80mm 150mm landscape;
            margin: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            direction: rtl;
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
            color: #000;
            background: #fff;
            width: 100%;
        }

        body {
            padding: 0;
            margin: 0;
        }

        .receipt {
            width: 100%;
            padding: 0;
            margin: 0;
            line-height: 1.35;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .header-cell {
            vertical-align: middle;
            padding: 2px 0;
        }

        .logo-cell {
            width: 28mm;
            text-align: right;
            padding-left: 4px;
        }

        .title-cell {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 0.5px;
            padding: 0 4px;
        }

        .spacer-cell {
            width: 1%;
        }

        .logo-cell img {
            max-width: 28mm;
            max-height: 26mm;
            height: auto;
            display: inline-block;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .label {
            width: 45%;
            font-weight: bold;
            text-align: right;
            padding-left: 4px;
        }

        .value {
            width: 55%;
            text-align: left;
            word-break: break-word;
            direction: ltr;
            unicode-bidi: isolate;
        }

        .value.rtl {
            direction: rtl;
            unicode-bidi: isolate;
            text-align: left;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 6px 0;
        }

        .footer {
            font-size: 10px;
            text-align: left;
            margin-top: 10px;
            padding-top: 6px;
            border-top: 1px solid #000;
            line-height: 1.4;
        }

        .footer div {
            margin: 1px 0;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <table class="header-table" role="presentation">
            <tr>
                <td class="header-cell logo-cell">
                    @if(!empty($gymLogoUrl))
                        <img src="{{ $gymLogoUrl }}" alt="Logo">
                    @endif
                </td>
                <td class="header-cell title-cell">رسید پرداخت</td>
                <td class="header-cell spacer-cell"></td>
            </tr>
        </table>

        <table class="info-table" role="presentation">
            <tr>
                <td class="label">نام عضو</td>
                <td class="value rtl">{{ persian_pdf_shape($member->name) }}</td>
            </tr>
            <tr>
                <td class="label">مبلغ پرداخت</td>
                <td class="value">{{ number_format($receipt->amount_paid, 0) }}</td>
            </tr>
            <tr>
                <td class="label">مانده</td>
                <td class="value">{{ number_format($receipt->remaining_balance, 0) }}</td>
            </tr>
            <tr>
                <td class="label">تاریخ</td>
                <td class="value">{{ $receipt->created_at->format('Y/m/d H:i') }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="footer">
            @if(!empty($gymAddress))<div>{{ $gymAddress }}</div>@endif
            <div>{{ $gymPhone }} @if(!empty($gymEmail)) | {{ $gymEmail }}@endif</div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>رسید پرداخت</title>
    @php
        include_once app_path('Support/persian_pdf_helpers.php');
    @endphp
    <style>
        @page {
            size: 80mm 150mm landscape;
            margin: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            background: #fff;
            direction: rtl;
            text-align: right;
            width: 100%;
        }

        body {
            padding: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        td {
            vertical-align: top;
        }

        .receipt {
            width: 100%;
            position: relative;
            min-height: 100%;
        }

        .header {
            width: 100%;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px solid #000;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .title-cell {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            padding: 0 4px;
        }

        .logo-cell {
            width: 1px;
            text-align: left;
            padding-left: 4px;
        }

        .logo-cell img {
            max-width: 40px;
            height: auto;
            display: block;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .content-table td {
            padding: 2.5px 0;
        }

        .label {
            width: 42%;
            font-weight: bold;
            padding-left: 6px;
        }

        .value {
            width: 58%;
            text-align: left;
            word-break: break-word;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            padding-bottom: 3px;
            margin-bottom: 4px;
            border-bottom: 1px solid #000;
        }

        .amount-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .amount-table td {
            padding: 2.5px 0;
        }

        .amount-label {
            width: 55%;
            font-weight: bold;
            padding-left: 6px;
        }

        .amount-value {
            width: 45%;
            text-align: left;
            white-space: nowrap;
        }

        .divider {
            border-top: 1px solid #000;
            margin: 8px 0;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            left: 10px;
            right: 10px;
            text-align: center;
            font-size: 10px;
            line-height: 1.4;
            color: #000;
        }

        .footer span {
            display: block;
        }

        .persian {
            font-family: "DejaVu Sans", sans-serif;
            direction: ltr;
            unicode-bidi: isolate;
            display: inline-block;
            line-height: 1.4;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <table class="header-table" role="presentation">
                <tr>
                    <td class="title-cell">رسید پرداخت</td>
                    <td class="logo-cell">
                        @if(!empty($gymLogoUrl))
                            <img src="{{ $gymLogoUrl }}" alt="لوگوی باشگاه">
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="section-title">جزئیات پرداخت</div>

        <table class="content-table" role="presentation">
            <tr>
                <td class="label">نام عضو:</td>
                <td class="value"><span class="persian" dir="ltr" lang="fa">{{ persian_pdf_shape($member->name) }}</span></td>
            </tr>
            <tr>
                <td class="label">مبلغ پرداختی:</td>
                <td class="value">{{ number_format($receipt->amount_paid, 0, '.', ',') }} تومان</td>
            </tr>
            <tr>
                <td class="label">مانده حساب:</td>
                <td class="value">{{ number_format($receipt->remaining_balance, 0, '.', ',') }} تومان</td>
            </tr>
            <tr>
                <td class="label">تاریخ:</td>
                <td class="value">{{ $receipt->created_at->format('Y/m/d H:i') }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="footer">
            @if(!empty($gymAddress))<span>{{ $gymAddress }}</span>@endif
            @if(!empty($gymPhone))<span>{{ $gymPhone }}</span>@endif
            @if(!empty($gymEmail))<span>{{ $gymEmail }}</span>@endif
        </div>
    </div>
</body>
</html>
