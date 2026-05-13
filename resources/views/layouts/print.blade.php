<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Print Plans')</title>
    <style>
        /* Print-specific styles */
        @media print {
            @page {
                size: A4;
                margin: 1cm;
            }

            body {
                font-family: 'Times New Roman', serif;
                font-size: 12pt;
                line-height: 1.4;
                color: #000;
                background: #fff !important;
            }

            .print-container {
                max-width: none;
                margin: 0;
                padding: 0;
            }

            /* Hide elements not needed for print */
            .no-print,
            .sidebar,
            .navbar,
            .button,
            .btn,
            button,
            a[href]:not([href^="#"]) {
                display: none !important;
            }

            /* Ensure content is visible */
            .print-header,
            .member-info,
            .plan-section,
            .print-footer {
                display: block !important;
                page-break-inside: avoid;
            }

            /* Page breaks */
            .page-break {
                page-break-before: always;
            }

            /* Typography for print */
            h1, h2, h3 {
                color: #000 !important;
                font-weight: bold;
            }

            h1 { font-size: 24pt; }
            h2 { font-size: 18pt; margin-top: 20pt; }
            h3 { font-size: 14pt; margin-top: 15pt; }

            p, li {
                color: #000 !important;
            }

            /* Tables and lists */
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 10pt 0;
            }

            th, td {
                border: 1px solid #000;
                padding: 5pt;
                text-align: left;
            }

            th {
                background: #f0f0f0 !important;
                font-weight: bold;
            }

            ul, ol {
                margin: 5pt 0;
                padding-left: 15pt;
            }

            li {
                margin-bottom: 3pt;
            }

            /* Spacing */
            .print-header {
                margin-bottom: 20pt;
                border-bottom: 2px solid #000;
                padding-bottom: 10pt;
            }

            .member-info {
                margin-bottom: 15pt;
            }

            .plan-section {
                margin-bottom: 20pt;
            }

            .print-footer {
                margin-top: 30pt;
                border-top: 1px solid #000;
                padding-top: 10pt;
                font-size: 10pt;
                color: #666;
            }

            /* Grid layouts for print */
            .gym-info {
                display: flex;
                align-items: center;
                gap: 15pt;
                margin-bottom: 10pt;
            }

            .gym-logo {
                width: 80pt;
                height: 80pt;
                object-fit: contain;
            }

            .gym-details h1 {
                margin: 0 0 5pt 0;
                font-size: 20pt;
            }

            .gym-details p {
                margin: 2pt 0;
                font-size: 11pt;
            }

            .document-title {
                text-align: center;
                margin-top: 15pt;
            }

            .document-title h1 {
                margin: 0;
                font-size: 22pt;
            }

            .print-date {
                font-size: 10pt;
                color: #666;
                margin-top: 5pt;
            }

            /* Member info layout */
            .member-details {
                display: flex;
                gap: 20pt;
                margin-top: 15pt;
            }

            .member-photo-section {
                flex-shrink: 0;
            }

            .member-photo,
            .member-photo-placeholder {
                width: 60pt;
                height: 60pt;
                border-radius: 50%;
                object-fit: cover;
            }

            .member-photo-placeholder {
                background: #f0f0f0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18pt;
                font-weight: bold;
                color: #666;
            }

            .member-stats {
                flex: 1;
            }

            .stat-row {
                display: flex;
                gap: 20pt;
                margin-bottom: 8pt;
            }

            .stat-item {
                flex: 1;
            }

            .stat-label {
                font-weight: bold;
                font-size: 11pt;
                margin-bottom: 3pt;
            }

            .stat-value {
                font-size: 12pt;
            }

            /* Workout plan layout */
            .workout-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15pt;
                margin-top: 10pt;
            }

            .workout-day {
                border: 1px solid #ccc;
                padding: 10pt;
                break-inside: avoid;
            }

            .workout-day h3 {
                margin: 0 0 8pt 0;
                font-size: 14pt;
                border-bottom: 1px solid #ccc;
                padding-bottom: 3pt;
            }

            .muscle-group {
                font-size: 11pt;
                margin-bottom: 8pt;
                font-style: italic;
            }

            .exercises {
                display: flex;
                flex-direction: column;
                gap: 8pt;
            }

            .exercise {
                border-left: 3pt solid #0066cc;
                padding-left: 8pt;
                background: #f9f9f9;
                padding: 5pt 8pt;
            }

            .exercise-name {
                font-weight: bold;
                font-size: 12pt;
                margin-bottom: 3pt;
            }

            .exercise-details {
                display: flex;
                gap: 10pt;
                font-size: 10pt;
                margin-bottom: 3pt;
            }

            .exercise-notes {
                font-size: 10pt;
                font-style: italic;
                color: #666;
            }

            /* Diet plan layout */
            .daily-macros {
                background: #f0f0f0;
                padding: 10pt;
                margin-bottom: 15pt;
                border: 1px solid #ccc;
            }

            .daily-macros h3 {
                margin: 0 0 8pt 0;
                font-size: 14pt;
            }

            .macros-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8pt;
            }

            .macro-item {
                text-align: center;
            }

            .macro-label {
                font-size: 10pt;
                font-weight: bold;
                margin-bottom: 2pt;
            }

            .macro-value {
                font-size: 12pt;
            }

            .meals {
                display: flex;
                flex-direction: column;
                gap: 12pt;
            }

            .meal {
                border: 1px solid #ccc;
                padding: 10pt;
                break-inside: avoid;
            }

            .meal h3 {
                margin: 0 0 5pt 0;
                font-size: 14pt;
                color: #006600;
            }

            .meal-calories {
                font-size: 11pt;
                font-weight: bold;
                margin-bottom: 8pt;
            }

            .meal-foods {
                margin-bottom: 8pt;
            }

            .meal-foods strong {
                font-size: 11pt;
            }

            .meal-foods ul {
                margin-top: 3pt;
            }

            .meal-macros {
                margin-top: 8pt;
                padding-top: 5pt;
                border-top: 1px solid #eee;
            }

            .macro-breakdown {
                display: flex;
                gap: 15pt;
                font-size: 10pt;
            }

            .meal-notes {
                margin-top: 8pt;
                font-size: 10pt;
                font-style: italic;
                color: #666;
            }

            /* Compact version styles */
            .member-summary {
                margin-bottom: 15pt;
                border: 1px solid #ccc;
                padding: 10pt;
                background: #f9f9f9;
            }

            .member-summary h2 {
                margin: 0 0 10pt 0;
                font-size: 16pt;
                border-bottom: 1px solid #ccc;
                padding-bottom: 5pt;
            }

            .summary-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8pt;
            }

            .summary-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 3pt 0;
            }

            .summary-label {
                font-weight: bold;
                font-size: 11pt;
            }

            .summary-value {
                font-size: 11pt;
            }

            .plan-summary {
                margin-bottom: 15pt;
            }

            .plan-summary h2 {
                margin: 0 0 10pt 0;
                font-size: 16pt;
                border-bottom: 1px solid #ccc;
                padding-bottom: 5pt;
            }

            .workout-summary {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8pt;
            }

            .day-summary {
                border: 1px solid #ccc;
                padding: 8pt;
                background: #f9f9f9;
            }

            .day-summary h3 {
                margin: 0 0 5pt 0;
                font-size: 12pt;
                font-weight: bold;
            }

            .muscle-focus {
                font-size: 10pt;
                font-style: italic;
                color: #666;
                margin-bottom: 5pt;
            }

            .exercise-list {
                display: flex;
                flex-direction: column;
                gap: 3pt;
            }

            .exercise-summary {
                display: flex;
                justify-content: space-between;
                align-items: center;
                font-size: 9pt;
                padding: 2pt 0;
            }

            .exercise-name {
                font-weight: bold;
                flex: 1;
            }

            .exercise-specs {
                font-size: 8pt;
                color: #666;
                margin-left: 5pt;
            }

            .nutrition-overview {
                background: #e8f5e8;
                padding: 8pt;
                margin-bottom: 10pt;
                border: 1px solid #ccc;
            }

            .macro-summary {
                display: flex;
                flex-direction: column;
                gap: 3pt;
            }

            .macro-total {
                font-size: 14pt;
                font-weight: bold;
                color: #006600;
            }

            .macro-breakdown {
                font-size: 10pt;
                color: #666;
            }

            .meal-summary {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 8pt;
            }

            .meal-compact {
                border: 1px solid #ccc;
                padding: 8pt;
                background: #f9f9f9;
            }

            .meal-compact h3 {
                margin: 0 0 5pt 0;
                font-size: 12pt;
                color: #006600;
            }

            .meal-content {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 5pt;
            }

            .meal-foods {
                flex: 1;
                display: flex;
                flex-wrap: wrap;
                gap: 3pt;
            }

            .food-item {
                font-size: 9pt;
                background: #fff;
                padding: 2pt 4pt;
                border-radius: 3pt;
                border: 1px solid #ddd;
            }

            .meal-calories {
                font-size: 10pt;
                font-weight: bold;
                color: #006600;
                flex-shrink: 0;
            }
        }

        /* Screen styles (minimal) */
        @media screen {
            body {
                margin: 0;
                padding: 20px;
                background: #f5f5f5;
            }

            .print-container {
                max-width: 800px;
                margin: 0 auto;
                background: white;
                padding: 30px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }

            .no-print {
                text-align: center;
                margin-bottom: 20px;
                padding: 10px;
                background: #e3f2fd;
                border: 1px solid #2196f3;
                border-radius: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="background: #2196f3; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 16px;">
            🖨️ Print Plan
        </button>
        <p style="margin: 10px 0 0 0; color: #666;">Click the button above to print this plan</p>
    </div>

    <div class="print-container">
        @yield('content')
    </div>

    <script>
        // Auto-print when loaded if print parameter is set
        if (window.location.search.includes('print=1')) {
            window.print();
        }
    </script>
</body>
</html>