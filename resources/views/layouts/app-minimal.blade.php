<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" class="theme-light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'سیستم مدیریت باشگاه') }}</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* Minimal, professional theme system */
        :root {
            /* Light Theme (Default) */
            --bg: #ffffff;
            --surface: #ffffff;
            --surface-soft: #f8fafc;
            --surface-hover: #f1f5f9;
            --text: #1e293b;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --border: #e2e8f0;
            --border-light: #f1f5f9;
            --accent: #3b82f6;
            --accent-soft: #dbeafe;
            --success: #10b981;
            --success-soft: #d1fae5;
            --warning: #f59e0b;
            --warning-soft: #fef3c7;
            --danger: #ef4444;
            --danger-soft: #fee2e2;
            --shadow: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-lg: 0 4px 6px rgba(0,0,0,0.07);
        }

        html.theme-dark {
            /* Dark Theme */
            --bg: #1e293b;
            --surface: #334155;
            --surface-soft: #475569;
            --surface-hover: #475569;
            --text: #f1f5f9;
            --text-muted: #cbd5e1;
            --text-light: #94a3b8;
            --border: #475569;
            --border-light: #334155;
            --accent: #60a5fa;
            --accent-soft: #1e40af;
            --success: #34d399;
            --success-soft: #065f46;
            --warning: #fbbf24;
            --warning-soft: #92400e;
            --danger: #f87171;
            --danger-soft: #991b1b;
            --shadow: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-lg: 0 4px 6px rgba(0,0,0,0.2);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Vazir', 'Iranian Sans', 'B Nazanin', 'Tahoma', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: var(--text);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            direction: rtl;
            text-align: right;
        }

        body[dir="ltr"] {
            direction: ltr;
            text-align: left;
        }

        /* Layout */
        .app-layout {
            display: flex;
            min-height: 100vh;
            flex-direction: row-reverse;
        }

        .sidebar {
            width: 240px;
            background: var(--surface);
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            font-size: 16px;
            color: var(--text);
        }

        .sidebar-nav {
            flex: 1;
            padding: 8px 0;
        }

        .sidebar-nav a {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.15s ease;
            text-align: right;
        }

        .sidebar-nav a:hover {
            background: var(--surface-soft);
            color: var(--text);
        }

        .sidebar-nav a.active {
            background: var(--accent-soft);
            color: var(--accent);
            font-weight: 500;
        }

        .sidebar-nav .icon {
            width: 16px;
            height: 16px;
            opacity: 0.7;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .navbar {
            height: 48px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .content {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
        }

        /* Components */
        .page-header {
            margin-bottom: 24px;
        }

        .page-title {
            margin: 0 0 4px 0;
            font-size: 24px;
            font-weight: 700;
            color: var(--text);
        }

        .page-subtitle {
            margin: 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 6px;
            box-shadow: var(--shadow);
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
        }

        .card-body {
            padding: 20px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s ease;
            background: var(--accent);
            color: white;
        }

        .btn:hover {
            background: var(--accent-soft);
            border-color: var(--accent);
        }

        .btn-outline {
            background: transparent;
            color: var(--text);
            border-color: var(--border);
        }

        .btn-outline:hover {
            background: var(--surface-soft);
        }

        .btn-success {
            background: var(--success);
        }

        .btn-success:hover {
            background: var(--success-soft);
        }

        .btn-danger {
            background: var(--danger);
        }

        .btn-danger:hover {
            background: var(--danger-soft);
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }

        /* Forms */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
        }

        .form-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            background: var(--surface);
            color: var(--text);
            font-size: 14px;
            outline: none;
            transition: border-color 0.15s ease;
        }

        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table th,
        .table td {
            padding: 12px 16px;
            text-align: right;
            border-bottom: 1px solid var(--border);
        }

        .table th {
            background: var(--surface-soft);
            font-weight: 600;
            color: var(--text);
        }

        .table tbody tr:hover {
            background: var(--surface-hover);
        }

        /* Status indicators */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-success {
            background: var(--success-soft);
            color: var(--success);
        }

        .status-warning {
            background: var(--warning-soft);
            color: var(--warning);
        }

        .status-error {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .status-info {
            background: var(--accent-soft);
            color: var(--accent);
        }

        /* Offline indicator */
        .offline-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            background: var(--warning-soft);
            color: var(--warning);
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .online-indicator {
            background: var(--success-soft);
            color: var(--success);
        }

        /* Theme switcher */
        .theme-switcher {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .theme-toggle {
            width: 32px;
            height: 16px;
            background: var(--border);
            border-radius: 8px;
            position: relative;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .theme-toggle.active {
            background: var(--accent);
        }

        .theme-toggle::after {
            content: '';
            position: absolute;
            top: 1px;
            left: 1px;
            width: 14px;
            height: 14px;
            background: white;
            border-radius: 50%;
            transition: transform 0.2s ease;
        }

        .theme-toggle.active::after {
            transform: translateX(16px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .content {
                padding: 16px;
            }

            .navbar {
                padding: 0 12px;
            }
        }

        /* Utility classes */
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-4 { gap: 16px; }
        .mb-4 { margin-bottom: 16px; }
        .text-sm { font-size: 12px; }
        .text-muted { color: var(--text-muted); }
        .hidden { display: none; }
    </style>
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                جم‌پرو
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                    داشبورد
                </a>
                <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">
                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    اعضا
                </a>
                <a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.*') ? 'active' : '' }}">
                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                    پرداخت‌ها
                </a>
                <a href="#" class="{{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    مصارف
                </a>
                <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    گزارش‌ها
                </a>
                <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zm-7.698 2.864a.75.75 0 100 1.5.75.75 0 000-1.5zM9 15a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    تنظیمات
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="navbar">
                <div class="navbar-left">
                    <h1 class="navbar-title">@yield('title', 'داشبورد')</h1>
                </div>
                <div class="navbar-right">
                    <span id="connectionStatus" class="status-badge status-success online-indicator">
                        <span id="statusDot">●</span>
                        آنلاین
                    </span>
                    <div class="theme-switcher">
                        <span class="text-sm text-muted">تم</span>
                        <div class="theme-toggle" id="themeToggle" onclick="toggleTheme()"></div>
                    </div>
                </div>
            </nav>

            <div class="content">
                @if(session('success'))
                    <div class="status-badge status-success" style="margin-bottom: 16px; display: block; padding: 12px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="status-badge status-error" style="margin-bottom: 16px; display: block; padding: 12px;">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Theme Management
        function toggleTheme() {
            const html = document.documentElement;
            const toggle = document.getElementById('themeToggle');

            if (html.classList.contains('theme-dark')) {
                html.classList.remove('theme-dark');
                html.classList.add('theme-light');
                toggle.classList.remove('active');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.remove('theme-light');
                html.classList.add('theme-dark');
                toggle.classList.add('active');
                localStorage.setItem('theme', 'dark');
            }

            // Reload custom colors for the new theme
            loadCustomColors();
        }

        function loadTheme() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const html = document.documentElement;
            const toggle = document.getElementById('themeToggle');

            html.classList.add(`theme-${savedTheme}`);
            if (savedTheme === 'dark') {
                toggle.classList.add('active');
            }

            // Load custom colors after theme is set
            loadCustomColors();
        }

        function loadCustomColors() {
            const colors = ['primary', 'success', 'warning', 'danger'];
            const colorMap = {
                primary: '--accent',
                success: '--success',
                warning: '--warning',
                danger: '--danger'
            };

            colors.forEach(colorName => {
                const savedColor = localStorage.getItem(`color_${colorName}`);
                if (savedColor) {
                    const cssVar = colorMap[colorName];
                    document.documentElement.style.setProperty(cssVar, savedColor);
                    // Also set soft variant (with transparency)
                    document.documentElement.style.setProperty(cssVar + '-soft', savedColor + '20');
                }
            });
        }

        // Connection Status
        function updateConnectionStatus() {
            const statusEl = document.getElementById('connectionStatus');
            const isOnline = navigator.onLine;

            if (isOnline) {
                statusEl.className = 'status-badge status-success online-indicator';
                statusEl.innerHTML = '<span id="statusDot">●</span> آنلاین';
            } else {
                statusEl.className = 'status-badge status-error';
                statusEl.innerHTML = '<span id="statusDot">●</span> آفلاین';
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadTheme();
            updateConnectionStatus();

            window.addEventListener('online', updateConnectionStatus);
            window.addEventListener('offline', updateConnectionStatus);
        });
    </script>
</body>
</html>