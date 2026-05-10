<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'سیستم مدیریت باشگاه') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            color-scheme: light;
            font-family: 'Vazirmatn', 'Inter', sans-serif;
            --bg: #f8fafc;
            --surface: #ffffff;
            --surface-soft: #f1f5f9;
            --surface-light: #e2e8f0;
            --surface-lighter: #f8fafc;
            --text: #0f172a;
            --muted: #64748b;
            --accent: #0f5cff;
            --accent-soft: #bfdbfe;
            --accent-muted: #e0f2fe;
            --border: rgba(15,23,42,0.12);
            --button: #0f5cff;
            --button-strong: #2563eb;
            --button-secondary: #64748b;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --shadow: 0 24px 70px rgba(15,23,42,0.08);
            --navbar: rgba(255,255,255,0.94);
            --navbar-text: #0f172a;
            --navbar-border: rgba(15,23,42,0.08);
            --sidebar: #ffffff;
            --sidebar-text: #0f172a;
            --sidebar-border: rgba(15,23,42,0.08);
            --sidebar-active: #bfdbfe;
            --sidebar-active-text: #0f5cff;
            --input-bg: #ffffff;
            --input-border: rgba(15,23,42,0.12);
            --table-header: #f8fafc;
            --table-row: #ffffff;
            --table-row-hover: #eff6ff;
            --card-bg: #ffffff;
            --footer-bg: transparent;
        }

        html.theme-dark {
            color-scheme: dark;
            --bg: #0b1120;
            --surface: #111827;
            --surface-soft: #1f2937;
            --surface-light: #1f2a44;
            --surface-lighter: #161d2f;
            --text: #e2e8f0;
            --muted: #94a3b8;
            --accent: #22d3ee;
            --accent-soft: #0f172a;
            --accent-muted: rgba(56,189,248,0.16);
            --border: rgba(148,163,184,0.18);
            --button: #22d3ee;
            --button-strong: #0ea5e9;
            --button-secondary: #64748b;
            --danger: #f87171;
            --success: #34d399;
            --warning: #fbbf24;
            --shadow: 0 24px 70px rgba(0,0,0,0.4);
            --navbar: rgba(15,23,42,0.96);
            --navbar-text: #e2e8f0;
            --navbar-border: rgba(255,255,255,0.08);
            --sidebar: #111827;
            --sidebar-text: #e2e8f0;
            --sidebar-border: rgba(148,163,184,0.18);
            --sidebar-active: rgba(56,189,248,0.16);
            --sidebar-active-text: #22d3ee;
            --input-bg: #111827;
            --input-border: rgba(148,163,184,0.24);
            --table-header: #111827;
            --table-row: #0f172a;
            --table-row-hover: #1e293b;
            --card-bg: #111827;
            --footer-bg: transparent;
        }

        html.theme-premium {
            color-scheme: light;
            --bg: #f6efff;
            --surface: #ffffff;
            --surface-soft: #f2e8ff;
            --surface-light: #e9d5ff;
            --surface-lighter: #faf5ff;
            --text: #1f2937;
            --muted: #6d28d9;
            --accent: #7c3aed;
            --accent-soft: #c4b5fd;
            --accent-muted: #ede9fe;
            --border: rgba(124,58,237,0.18);
            --button: #7c3aed;
            --button-strong: #5b21b6;
            --button-secondary: #6d28d9;
            --danger: #db2777;
            --success: #059669;
            --warning: #d97706;
            --shadow: 0 24px 70px rgba(124,58,237,0.12);
            --navbar: rgba(255,255,255,0.94);
            --navbar-text: #1f2937;
            --navbar-border: rgba(124,58,237,0.15);
            --sidebar: #ffffff;
            --sidebar-text: #1f2937;
            --sidebar-border: rgba(124,58,237,0.15);
            --sidebar-active: #ede9fe;
            --sidebar-active-text: #7c3aed;
            --input-bg: #ffffff;
            --input-border: rgba(124,58,237,0.22);
            --table-header: #f3e8ff;
            --table-row: #ffffff;
            --table-row-hover: #ede9fe;
            --card-bg: #ffffff;
            --footer-bg: transparent;
        }

        * { box-sizing: border-box; }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            white-space: nowrap;
            border: 0;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: var(--font-sans, 'Vazirmatn', 'Inter', sans-serif);
            display: flex;
            direction: rtl;
            text-align: right;
        }

        html[dir="ltr"] body {
            direction: ltr;
            text-align: left;
        }

        .sidebar {
            width: 280px;
            background: var(--sidebar);
            border-left: 1px solid var(--sidebar-border);
            padding: 24px 0;
            position: fixed;
            right: 0;
            left: auto;
            height: 100vh;
            overflow-y: auto;
            z-index: 20;
        }

        html[dir="ltr"] body .sidebar {
            border-left: none;
            border-right: 1px solid var(--sidebar-border);
            left: 0;
            right: auto;
        }

        .sidebar-nav a {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            margin-bottom: 4px;
            text-align: right;
        }

        html[dir="ltr"] body .sidebar-nav a {
            flex-direction: row;
            justify-content: flex-start;
            text-align: left;
        }

        .main-content {
            flex: 1;
            margin-right: 280px;
            min-height: 100vh;
        }

        html[dir="ltr"] body .main-content {
            margin-right: 0;
            margin-left: 280px;
        }

        .sidebar-header {
            padding: 0 24px 24px;
            border-bottom: 1px solid var(--sidebar-border);
            margin-bottom: 24px;
        }

        .sidebar-brand {
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--accent);
            font-size: 1.1rem;
        }

        .sidebar-nav {
            padding: 0 16px;
        }

        .sidebar-nav a {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            margin-bottom: 4px;
            text-align: right;
        }

        .sidebar-nav a:hover {
            background: var(--surface-soft);
        }

        .sidebar-nav a.active {
            background: var(--sidebar-active);
            color: var(--sidebar-active-text);
            font-weight: 600;
        }

        .sidebar-nav .icon {
            width: 20px;
            height: 20px;
            opacity: 0.7;
        }

        .main-content {
            flex: 1;
            margin-right: 280px;
            min-height: 100vh;
        }

        .navbar {
            background: var(--navbar);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--navbar-border);
            color: var(--navbar-text);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            direction: rtl;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--navbar-text);
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notification-btn {
            position: relative;
            background: none;
            border: none;
            color: var(--navbar-text);
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .notification-btn:hover {
            background: var(--surface-soft);
        }

        .notification-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid var(--navbar);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .user-menu:hover {
            background: var(--surface-soft);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .theme-switcher {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .theme-select {
            border-radius: 8px;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            color: var(--text);
            padding: 8px 12px;
            font-size: 0.9rem;
            outline: none;
            cursor: pointer;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-title {
            margin: 0 0 8px;
            font-size: clamp(1.8rem, 2.6vw, 2.8rem);
            letter-spacing: -0.03em;
            font-weight: 700;
        }

        .page-subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 1rem;
        }

        .grid { display: grid; gap: 24px; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, var(--accent-soft), transparent 50%);
            pointer-events: none;
        }

        .stat-card-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: var(--accent-muted);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
        }

        .stat-info h3 {
            font-size: 0.9rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .stat-info p {
            font-size: 2rem;
            margin: 0;
            color: var(--text);
            font-weight: 700;
        }

        .table-card {
            overflow-x: auto;
            border-radius: 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 720px;
        }

        th, td {
            padding: 16px 20px;
            text-align: right;
            color: var(--text);
        }

        th {
            background: var(--table-header);
            color: var(--muted);
            text-transform: uppercase;
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            font-weight: 600;
            border-bottom: 1px solid var(--border);
        }

        td {
            background: var(--table-row);
            border-bottom: 1px solid var(--border);
        }

        tr:hover td { background: var(--table-row-hover); }

        .button, .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            background: linear-gradient(135deg, var(--button), var(--button-strong));
            border: 1px solid transparent;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
            font-weight: 600;
            letter-spacing: 0.03em;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .button:hover, .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .button-secondary {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--border);
            box-shadow: none;
        }

        .button-secondary:hover {
            background: var(--surface-soft);
        }

        .button-success {
            background: var(--success);
            border-color: rgba(16,185,129,0.3);
        }

        .button-danger {
            background: var(--danger);
            border-color: rgba(239,68,68,0.3);
        }

        .button-outline {
            background: transparent;
            color: var(--accent);
            border: 1px solid var(--accent-soft);
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            background: transparent;
            border: none;
            color: var(--muted);
            padding: 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .dropdown-toggle:hover {
            background: var(--surface-soft);
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: var(--shadow);
            min-width: 160px;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .dropdown.open .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 16px;
            color: var(--text);
            text-decoration: none;
            transition: background 0.2s ease;
        }

        .dropdown-menu a:hover {
            background: var(--surface-soft);
        }

        .dropdown-menu a.danger {
            color: var(--danger);
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            background: rgba(245,158,11,0.12);
            color: #92400e;
            border: 1px solid rgba(245,158,11,0.2);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: rgba(16,185,129,0.12);
            color: #065f46;
            border-color: rgba(16,185,129,0.25);
        }

        .alert-danger {
            background: rgba(239,68,68,0.12);
            color: #7f1d1d;
            border-color: rgba(239,68,68,0.25);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text);
            font-size: 0.9rem;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            color: var(--text);
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
        }

        .card-header {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text);
        }

        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal.open {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: var(--surface);
            border-radius: 16px;
            padding: 24px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal.open .modal-content {
            transform: scale(1);
        }

        .modal-header {
            margin-bottom: 16px;
        }

        .modal-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text);
        }

        .modal-body {
            margin-bottom: 24px;
            color: var(--muted);
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px 20px;
            box-shadow: var(--shadow);
            z-index: 1001;
            transform: translateX(400px);
            transition: transform 0.3s ease;
            max-width: 300px;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast-success {
            border-color: var(--success);
            background: rgba(16,185,129,0.05);
        }

        .toast-error {
            border-color: var(--danger);
            background: rgba(239,68,68,0.05);
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.8rem;
            border-radius: 9999px;
            border: 1px solid transparent;
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(15,23,42,0.05);
            color: var(--text);
        }

        .status-chip.status-success {
            background: rgba(16,185,129,0.12);
            border-color: rgba(16,185,129,0.25);
            color: var(--success);
        }

        .status-chip.status-warning {
            background: rgba(245,158,11,0.12);
            border-color: rgba(245,158,11,0.25);
            color: var(--warning);
        }

        .status-chip.status-error {
            background: rgba(239,68,68,0.12);
            border-color: rgba(239,68,68,0.25);
            color: var(--danger);
        }

        .status-chip.status-info {
            background: rgba(59,130,246,0.12);
            border-color: rgba(59,130,246,0.25);
            color: var(--accent);
        }

        .hidden {
            display: none !important;
        }

        #offlineBanner {
            margin-bottom: 1rem;
        }

        .status-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .status-row span {
            white-space: nowrap;
        }

        .loading {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid var(--border);
            border-top: 2px solid var(--accent);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .footer {
            text-align: center;
            padding: 24px 0;
            color: var(--muted);
            font-size: 0.9rem;
            background: var(--footer-bg);
            border-top: 1px solid var(--border);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 12px 16px;
            }

            .container {
                padding: 16px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .stat-card-content {
                flex-direction: column;
                text-align: center;
            }

            .modal-content {
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">{{ __('messages.brand') }}</div>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                </svg>
                {{ __('messages.dashboard') }}
            </a>
            <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
                {{ __('messages.members') }}
            </a>
            <a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                </svg>
                {{ __('messages.payments') }}
            </a>
            <a href="#" class="{{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                </svg>
                {{ __('messages.expenses') }}
            </a>
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ __('messages.reports') }}
            </a>
            <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v9a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 7a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                {{ __('messages.attendance') }}
            </a>
            <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zm-7.698 2.864a.75.75 0 100 1.5.75.75 0 000-1.5zM9 15a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                {{ __('messages.settings') }}
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar">
            <div class="navbar-left">
                <button class="sidebar-toggle notification-btn md:hidden" onclick="toggleSidebar()">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <h1 class="navbar-title">@yield('title', __('messages.dashboard'))</h1>
            </div>
            <div class="navbar-right">
                <button class="notification-btn">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                    <span class="notification-badge"></span>
                </button>
                <div class="user-menu">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                    <span class="hidden sm:block">{{ auth()->user()->name ?? 'User' }}</span>
                </div>
                <span id="navbarConnection" class="status-chip status-info">{{ __('messages.online') }}</span>
                <div class="theme-switcher">
                    <label for="themeSelector" class="sr-only">{{ __('messages.theme') }}</label>
                    <select id="themeSelector" class="theme-select">
                        <option value="light">{{ __('messages.theme_light') }}</option>
                        <option value="dark">{{ __('messages.theme_dark') }}</option>
                        <option value="premium">{{ __('messages.theme_premium') }}</option>
                    </select>
                </div>
                <div class="language-switcher">
                    <label for="localeSelector" class="sr-only">{{ __('messages.select_language') }}</label>
                    <select id="localeSelector" class="theme-select" onchange="window.location.href = this.value;">
                        <option value="{{ route('locale.switch', 'fa') }}" {{ app()->getLocale() === 'fa' ? 'selected' : '' }}>{{ __('messages.language_fa') }}</option>
                        <option value="{{ route('locale.switch', 'en') }}" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('messages.language_en') }}</option>
                    </select>
                </div>
            </div>
        </nav>

        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div id="offlineBanner" class="alert alert-warning hidden">
                <strong>{{ __('messages.offline_mode') }}</strong> — {{ __('messages.offline_save') }}
            </div>

            <div id="offlineFormHint" class="alert alert-info hidden">
                <strong>{{ __('messages.offline_supported') }}</strong> {{ __('messages.offline_form_sync') }}
            </div>

            <div class="status-row">
                <span class="status-chip status-info">{{ __('messages.connection_status') }}: <span id="connectionStatus">{{ __('messages.checking_status') }}</span></span>
                <span id="syncStatus" class="status-chip status-warning">{{ __('messages.waiting_status') }}</span>
            </div>

            @yield('content')
        </div>
    </div>

    <!-- Modals -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.confirm_operation') }}</h3>
            </div>
            <div class="modal-body">
                {{ __('messages.confirm_text') }}
            </div>
            <div class="modal-footer">
                <button class="button button-secondary" onclick="closeModal()">{{ __('messages.confirm_cancel') }}</button>
                <button class="button button-danger" id="confirmBtn">{{ __('messages.confirm_ok') }}</button>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toastContainer"></div>

    @php($gymI18n = [
        'online' => __('messages.online'),
        'offline' => __('messages.offline'),
        'confirm_text' => __('messages.confirm_text'),
        'checking_status' => __('messages.checking_status'),
        'waiting_status' => __('messages.waiting_status'),
        'syncing' => __('messages.syncing'),
        'sync_all_synced' => __('messages.sync_all_synced'),
        'sync_saved_locally' => __('messages.sync_saved_locally'),
        'toast_offline_saved' => __('messages.toast_offline_saved'),
        'toast_sync_failed' => __('messages.toast_sync_failed'),
        'toast_back_online' => __('messages.toast_back_online'),
        'toast_offline_mode' => __('messages.toast_offline_mode'),
        'status_back_online' => __('messages.status_back_online'),
    ])
    <script>
        window.GYM_I18N = {!! json_encode($gymI18n, JSON_UNESCAPED_UNICODE) !!};

        const themeSelector = document.getElementById('themeSelector');
        const themeStorageKey = 'gym_theme';

        // Theme Management
        const applyTheme = (theme) => {
            document.documentElement.classList.remove('theme-light', 'theme-dark', 'theme-premium');
            document.documentElement.classList.add(`theme-${theme}`);
            if (themeSelector) themeSelector.value = theme;
            localStorage.setItem(themeStorageKey, theme);
        };

        const loadTheme = () => {
            const storedTheme = localStorage.getItem(themeStorageKey) || 'light';
            if (['light', 'dark', 'premium'].includes(storedTheme)) {
                applyTheme(storedTheme);
            } else {
                applyTheme('light');
            }
        };

        if (themeSelector) {
            themeSelector.addEventListener('change', (event) => {
                applyTheme(event.target.value);
            });
        }

        // Sidebar Toggle
        const toggleSidebar = () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        };

        // Modal Management
        const openModal = (action, message = window.GYM_I18N?.confirm_text) => {
            const modal = document.getElementById('confirmModal');
            const confirmBtn = document.getElementById('confirmBtn');
            const modalBody = modal.querySelector('.modal-body');

            modalBody.textContent = message;
            confirmBtn.onclick = () => {
                closeModal();
                if (action) action();
            };

            modal.classList.add('open');
        };

        const closeModal = () => {
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('open');
        };

        // Toast Notifications
        const showToast = (message, type = 'success') => {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div style="display: flex; align-items: center; gap: 12px;">
                    ${type === 'success' ? `
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    ` : `
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    `}
                    <span>${message}</span>
                </div>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    container.removeChild(toast);
                }, 300);
            }, 3000);
        };

        // Dropdown Management
        document.addEventListener('click', (e) => {
            const dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });
        });

        document.addEventListener('click', (e) => {
            if (e.target.closest('.dropdown-toggle')) {
                const dropdown = e.target.closest('.dropdown');
                dropdown.classList.toggle('open');
            }
        });

        // Initialize
        loadTheme();

        const offlineQueueKey = 'gym_offline_queue';
        const offlineBanner = document.getElementById('offlineBanner');
        const offlineFormHint = document.getElementById('offlineFormHint');
        const connectionStatusEl = document.getElementById('connectionStatus');
        const navbarConnection = document.getElementById('navbarConnection');
        const syncStatusEl = document.getElementById('syncStatus');

        const loadOfflineQueue = () => {
            try {
                return JSON.parse(localStorage.getItem(offlineQueueKey) || '[]');
            } catch (error) {
                return [];
            }
        };

        const saveOfflineQueue = (queue) => {
            localStorage.setItem(offlineQueueKey, JSON.stringify(queue));
        };

        const updateSyncStatus = (message, status = 'info') => {
            if (!syncStatusEl) return;
            syncStatusEl.textContent = message;
            syncStatusEl.className = `status-chip status-${status}`;
        };

        const updateConnectionStatus = (online, justReconnected = false) => {
            const statusText = online
                ? (justReconnected ? (window.GYM_I18N?.status_back_online || window.GYM_I18N?.online) : window.GYM_I18N?.online)
                : window.GYM_I18N?.offline;
            const statusClass = online ? 'status-success' : 'status-error';

            if (navbarConnection) {
                navbarConnection.textContent = statusText;
                navbarConnection.className = `status-chip ${statusClass}`;
            }
            if (connectionStatusEl) {
                connectionStatusEl.textContent = online ? (window.GYM_I18N?.online || 'Online') : (window.GYM_I18N?.offline || 'Offline');
            }
            if (offlineBanner) {
                offlineBanner.classList.toggle('hidden', online);
            }
            if (offlineFormHint) {
                offlineFormHint.classList.toggle('hidden', online);
            }

            if (online) {
                updateSyncStatus(window.GYM_I18N?.syncing || 'Syncing…', 'success');
                syncQueuedRequests();
            } else {
                updateSyncStatus(window.GYM_I18N?.waiting_status || 'Waiting…', 'warning');
            }
        };

        const queueOfflineRequest = (item) => {
            const queue = loadOfflineQueue();
            queue.push(item);
            saveOfflineQueue(queue);
            updateSyncStatus((window.GYM_I18N?.sync_saved_locally || 'Saved locally') + `: ${queue.length}`, 'warning');
            showToast(window.GYM_I18N?.toast_offline_saved || 'Saved offline.', 'success');
        };

        const syncQueuedRequests = async () => {
            const queue = loadOfflineQueue();
            if (!queue.length) {
                updateSyncStatus(window.GYM_I18N?.sync_all_synced || 'All synced', 'success');
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''.trim();
            const remaining = [];

            for (const item of queue) {
                try {
                    const response = await fetch(item.url, {
                        method: item.method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(item.payload),
                    });

                    if (!response.ok) {
                        throw new Error(response.statusText || 'Sync failed');
                    }
                } catch (error) {
                    console.error('Offline sync error:', error);
                    remaining.push(item);
                    updateSyncStatus('همگام‌سازی به دلیل مشکل شبکه متوقف شد', 'error');
                    showToast(window.GYM_I18N?.toast_sync_failed || 'Sync failed. Will retry.', 'error');
                }
            }

            saveOfflineQueue(remaining);

            if (!remaining.length) {
                updateSyncStatus('Offline data synced successfully', 'success');
                showToast(window.GYM_I18N?.sync_all_synced || 'All synced', 'success');
            }
        };

        const initOfflineForms = () => {
            const offlineForms = document.querySelectorAll('form[data-offline-sync="true"]');

            offlineForms.forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (navigator.onLine) {
                        return;
                    }

                    event.preventDefault();
                    const formData = new FormData(form);
                    const payload = {};
                    formData.forEach((value, key) => {
                        if (value instanceof File || key === '_token' || key === '_method') {
                            return;
                        }
                        payload[key] = value;
                    });

                    const url = form.dataset.offlineSyncUrl || form.action;
                    const method = (form.method || 'POST').toUpperCase();

                    queueOfflineRequest({
                        url,
                        method,
                        payload,
                    });
                });
            });
        };

        window.addEventListener('online', () => {
            updateConnectionStatus(true, true);
            showToast(window.GYM_I18N?.toast_back_online || 'Back online — syncing…', 'success');
        });

        window.addEventListener('offline', () => {
            updateConnectionStatus(false);
            showToast(window.GYM_I18N?.toast_offline_mode || 'Offline mode.', 'warning');
        });

        document.addEventListener('DOMContentLoaded', () => {
            updateConnectionStatus(navigator.onLine);
            initOfflineForms();
        });

        // Global functions for use in templates
        window.openModal = openModal;
        window.closeModal = closeModal;
        window.showToast = showToast;
        window.toggleSidebar = toggleSidebar;
    </script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then((registration) => {
                        console.log('Service Worker registered:', registration.scope);
                    })
                    .catch((error) => {
                        console.warn('Service Worker registration failed:', error);
                    });
            });
        }
    </script>
</body>
</html>
