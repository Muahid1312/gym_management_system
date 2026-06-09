<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" class="theme-light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Gym Management System') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Light theme - default */
        :root,
        html.theme-light {
            --primary: #F97316;
            --primary-dark: #EA580C;
            --primary-light: #FEDF89;
            --secondary: #1E40AF;
            --sidebar-bg: #0F172A;
            --sidebar-text: #E2E8F0;
            --sidebar-active: #F97316;
            --body-bg: #F8FAFC;
            --text-color: #1F2937;
            --card-bg: #FFFFFF;
            --header-bg: #FFFFFF;
            --panel-bg: #F8FAFC;
            --search-bg: #F8FAFC;
            --icon-bg: #F8FAFC;
            --icon-hover: #EFF6FF;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* Dark theme */
        html.theme-dark {
            color-scheme: dark;
            --primary: #F97316;
            --primary-dark: #EA580C;
            --primary-light: #FEDF89;
            --secondary: #1E40AF;
            --sidebar-bg: #020617;
            --sidebar-text: #E2E8F0;
            --sidebar-active: #F97316;
            --body-bg: #0F172A;
            --text-color: #E2E8F0;
            --card-bg: #111827;
            --header-bg: #111827;
            --panel-bg: #1E293B;
            --search-bg: #111827;
            --icon-bg: #111827;
            --icon-hover: #1F2937;
            --text-muted: #94A3B8;
            --border-color: #334155;
            --shadow: 0 4px 24px rgba(0, 0, 0, 0.35);
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.35);
        }

        html {
            font-family: 'Inter', 'Poppins', sans-serif;
        }

        body {
            background-color: var(--body-bg);
            color: var(--text-color);
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar.hidden {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo {
            font-size: 24px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            color: var(--primary);
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .nav-item:hover {
            background-color: rgba(249, 115, 22, 0.1);
            border-left-color: var(--primary);
        }

        .nav-item.active {
            background-color: rgba(249, 115, 22, 0.15);
            border-left-color: var(--primary);
            color: var(--primary);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(226, 232, 240, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--sidebar-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 12px;
            color: rgba(226, 232, 240, 0.6);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        /* ========== HEADER ========== */
        .top-header {
            background-color: var(--header-bg);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-sm);
            gap: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
            flex: 1;
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background-color: var(--search-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 8px 16px;
            gap: 8px;
            min-width: 280px;
        }

        .search-box input {
            background: none;
            border: none;
            outline: none;
            font-size: 14px;
            flex: 1;
            color: var(--text-color);
        }

        .search-box input::placeholder {
            color: var(--text-muted);
        }

        .icon-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--icon-bg);
            border: 1px solid var(--border-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            position: relative;
        }

        .icon-button:hover {
            background-color: var(--icon-hover);
            border-color: var(--primary);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 12px;
            height: 12px;
            background-color: #EF4444;
            border-radius: 50%;
            border: 2px solid var(--card-bg);
        }

        /* ========== CONTENT AREA ========== */
        .content-area {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
        }

        /* ========== CARDS ========== */
        .card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 24px;
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
        }

        .card-subtitle {
            font-size: 12px;
            color: #94A3B8;
            margin: 0;
            margin-top: 4px;
        }

        /* ========== STAT CARDS ========== */
        .stat-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .stat-icon.blue {
            background-color: #EFF6FF;
            color: #1E40AF;
        }

        .stat-icon.green {
            background-color: #DCFCE7;
            color: #16A34A;
        }

        .stat-icon.orange {
            background-color: #FFEDD5;
            color: var(--primary);
        }

        .stat-icon.purple {
            background-color: #F3E8FF;
            color: #7C3AED;
        }

        .stat-content h3 {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            margin: 0 0 8px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-content p {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-color);
            margin: 0 0 8px 0;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .stat-trend.positive {
            color: #16A34A;
        }

        .stat-trend.negative {
            color: #EF4444;
        }

        /* ========== BUTTONS ========== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .btn-secondary {
            background-color: #E2E8F0;
            color: #475569;
        }

        .btn-secondary:hover {
            background-color: #CBD5E1;
        }

        .btn-pill {
            border-radius: 9999px;
            padding: 10px 20px;
        }

        /* ========== BADGES ========== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-active {
            background-color: #DCFCE7;
            color: #16A34A;
        }

        .badge-expired {
            background-color: #FEE2E2;
            color: #DC2626;
        }

        .badge-pending {
            background-color: #FEF9C3;
            color: #CA8A04;
        }

        .badge-info {
            background-color: #EFF6FF;
            color: #1E40AF;
        }

        /* ========== TABLES ========== */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th {
            background-color: var(--panel-bg);
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-color);
        }

        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: var(--panel-bg);
        }

        tbody tr:nth-child(even) {
            background-color: rgba(248, 250, 252, 0.85);
        }

        /* ========== FORMS ========== */
        .drawer {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background-color: var(--card-bg);
            box-shadow: -4px 0 24px rgba(0, 0, 0, 0.12);
            display: flex;
            flex-direction: column;
            z-index: 1500;
            transition: right 0.3s ease;
            overflow-y: auto;
        }

        .drawer.active {
            right: 0;
        }

        .drawer-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .drawer-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
        }

        .drawer-close {
            background: none;
            border: none;
            cursor: pointer;
            color: #64748B;
            font-size: 24px;
            transition: color 0.2s ease;
        }

        .drawer-close:hover {
            color: #1F2937;
        }

        .drawer-body {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
        }

        .drawer-footer {
            padding: 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 12px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            background-color: var(--card-bg);
            color: var(--text-color);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }

        .form-group input.error,
        .form-group select.error,
        .form-group textarea.error {
            border-color: #EF4444;
        }

        .form-error {
            font-size: 12px;
            color: #EF4444;
            margin-top: 6px;
        }

        .form-section {
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .form-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .form-section-title {
            font-size: 14px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748B;
        }

        /* ========== CHART CONTAINER ========== */
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 24px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
            }

            .sidebar-header {
                justify-content: center;
                padding: 16px;
            }

            .sidebar-logo {
                font-size: 20px;
            }

            .nav-item {
                justify-content: center;
                padding: 12px 16px;
            }

            .nav-item span {
                display: none;
            }

            .sidebar-footer {
                flex-direction: column;
                gap: 8px;
                padding: 16px;
            }

            .user-info {
                display: none;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
            }

            .main-content {
                margin-left: 80px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 260px;
                margin-left: -260px;
            }

            .sidebar.mobile-open {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .header-left {
                gap: 12px;
            }

            .search-box {
                display: none;
            }

            .stat-card {
                flex-direction: column;
            }

            .drawer {
                width: 100%;
                right: -100%;
            }

            .content-area {
                padding: 16px;
            }
        }

        @media (max-width: 640px) {
            .page-title {
                font-size: 18px;
            }

            .icon-button {
                width: 36px;
                height: 36px;
            }

            .header-right {
                gap: 12px;
            }

            .top-header {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="layout-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">GYM</div>
                <span style="display: none;">Gym Management</span>
            </div>

            <nav class="sidebar-nav">
                <a href="/dashboard" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2.422-7.267a2 2 0 011.9-1.267h12.356a2 2 0 011.9 1.267L21 12M3 12a9 9 0 0118 0m0 0l-1.35 4.05a2 2 0 01-1.898 1.45H6.248a2 2 0 01-1.898-1.45L3 12" />
                        </svg>
                    </div>
                    <span>Dashboard</span>
                </a>

                <a href="/members" class="nav-item {{ request()->is('members*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 001.591-.079 8.988 8.988 0 011.949 1.379M15 19.128v-.008a9.46 9.46 0 00-3.608-9.375m0 0a3.75 3.75 0 11-7.5 0m7.5 0a3.75 3.75 0 11-7.5 0m6 0h.008v.008h-.008v-.008zm0 0h6m-6 0v6m0-6v-6" />
                        </svg>
                    </div>
                    <span>Members</span>
                </a>

                <a href="/trainers" class="nav-item {{ request()->is('trainers*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72v-7.5m0 7.5a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5m0 0v-7.5m0-6a2.25 2.25 0 110-4.5 2.25 2.25 0 010 4.5m0 6a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5m-9-13.5a2.25 2.25 0 110-4.5 2.25 2.25 0 010 4.5m0 6a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5m0 6a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5" />
                        </svg>
                    </div>
                    <span>Trainers</span>
                </a>

                <a href="/plans" class="nav-item {{ request()->is('plans*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5" />
                        </svg>
                    </div>
                    <span>Plans</span>
                </a>

                <a href="/lockers" class="nav-item {{ request()->is('lockers*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 9.75V6.75A2.25 2.25 0 017.5 4.5h9a2.25 2.25 0 012.25 2.25v3m-15 0h15M7.5 4.5v14.25a2.25 2.25 0 002.25 2.25h5.25a2.25 2.25 0 002.25-2.25V4.5" />
                        </svg>
                    </div>
                    <span>Lockers</span>
                </a>

                <a href="/generator" class="nav-item {{ request()->is('generator*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <span>Generator</span>
                </a>

                <a href="/payments" class="nav-item {{ request()->is('payments*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    <span>Payments</span>
                </a>

                <a href="/receipts" class="nav-item {{ request()->is('receipts*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25V9.75m6 4.5V9.75M9 19.5h6m2.25-15H6.75A2.25 2.25 0 004.5 6.75v10.5A2.25 2.25 0 006.75 19.5h10.5a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0016.5 4.5z" />
                        </svg>
                    </div>
                    <span>Receipts</span>
                </a>

                <a href="/attendance" class="nav-item {{ request()->is('attendance*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span>Attendance</span>
                </a>

                <a href="/schedules" class="nav-item {{ request()->is('schedules*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                    </div>
                    <span>Schedules</span>
                </a>

                <a href="/reports" class="nav-item {{ request()->is('reports*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0013.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M0 0h24v24H0z" />
                        </svg>
                    </div>
                    <span>Reports</span>
                </a>

                <a href="/settings" class="nav-item {{ request()->is('settings*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.592c.55 0 1.02.398 1.11.94m-.213 9.526c.918.856 1.52 2.081 1.52 3.474 0 1.393-.602 2.618-1.52 3.474m0-9.474c-.918-.856-1.52-2.081-1.52-3.474 0-1.393.602-2.618 1.52-3.474m3.097 9.604a9.01 9.01 0 00-1.52-3.474m0 0a3.75 3.75 0 00-7.5 0" />
                        </svg>
                    </div>
                    <span>Settings</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-avatar">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="user-role">Admin</div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left">
                    <button id="menu-toggle" class="icon-button" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <h1 class="page-title">{{ $title ?? 'Dashboard' }}</h1>
                </div>

                <div class="header-right">
                    <div class="search-box">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; height: 18px; color: var(--text-muted);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0010.5 10.5z" />
                        </svg>
                        <input type="text" placeholder="Search...">
                    </div>

                    <button class="icon-button" title="Notifications">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <div class="notification-badge"></div>
                    </button>

                    <button id="theme-toggle" class="icon-button" title="Toggle theme">
                        <span id="theme-icon" style="font-size: 18px; line-height: 1;">🌙</span>
                    </button>
                    <button class="icon-button" title="Profile">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15a7.488 7.488 0 00-5.982 3.725m11.964 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275m11.963 0A24.973 24.973 0 0112 19.5" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Content -->
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Robust theme system
        function setTheme(theme) {
            const html = document.documentElement;
            const isDark = theme === 'dark';
            
            // Remove both classes first
            html.classList.remove('theme-light', 'theme-dark');
            
            // Add the correct one
            if (isDark) {
                html.classList.add('theme-dark');
            } else {
                html.classList.add('theme-light');
            }
            
            // Save to localStorage
            try {
                localStorage.setItem('theme', theme);
            } catch (e) {
                console.warn('Could not save theme to localStorage:', e);
            }
            
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const themeIcon = document.getElementById('theme-icon');
            const themeToggle = document.getElementById('theme-toggle');
            
            if (!themeIcon || !themeToggle) {
                console.warn('Theme icon or toggle not found');
                return;
            }
            
            const isDark = document.documentElement.classList.contains('theme-dark');
            themeIcon.textContent = isDark ? '☀️' : '🌙';
            themeToggle.setAttribute('title', isDark ? 'Switch to light mode' : 'Switch to dark mode');
        }

        function initializeTheme() {
            let savedTheme = null;
            
            try {
                savedTheme = localStorage.getItem('theme');
            } catch (e) {
                console.warn('Could not read theme from localStorage:', e);
            }
            
            if (savedTheme === 'dark' || savedTheme === 'light') {
                setTheme(savedTheme);
            } else {
                // Check system preference
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                setTheme(prefersDark ? 'dark' : 'light');
            }
        }

        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing theme system...');
            
            // Initialize theme
            initializeTheme();
            
            // Attach click handler to theme toggle
            const themeToggle = document.getElementById('theme-toggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isDark = document.documentElement.classList.contains('theme-dark');
                    const newTheme = isDark ? 'light' : 'dark';
                    
                    console.log('Theme toggle clicked. Current:', isDark ? 'dark' : 'light', 'Switching to:', newTheme);
                    setTheme(newTheme);
                });
                console.log('Theme toggle click handler attached');
            } else {
                console.error('Theme toggle button not found in DOM');
            }
            
            // Mobile menu toggle
            const menuToggle = document.getElementById('menu-toggle');
            if (menuToggle) {
                menuToggle.addEventListener('click', () => {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) {
                        sidebar.classList.toggle('mobile-open');
                    }
                });
            }
            
            // Close sidebar when clicking on a nav item (mobile)
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        const sidebar = document.getElementById('sidebar');
                        if (sidebar) {
                            sidebar.classList.remove('mobile-open');
                        }
                    }
                });
            });
            
            // Responsive menu toggle visibility
            function updateMenuToggle() {
                const menuToggle = document.getElementById('menu-toggle');
                if (!menuToggle) return;
                
                if (window.innerWidth < 768) {
                    menuToggle.style.display = 'flex';
                } else {
                    menuToggle.style.display = 'none';
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) {
                        sidebar.classList.remove('mobile-open');
                    }
                }
            }
            
            window.addEventListener('resize', updateMenuToggle);
            updateMenuToggle();
        });
    </script>
</body>
</html>
