@props(['sidebar' => [], 'topNav' => [], 'footer' => []])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #6b7280;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --light: #f9fafb;
            --dark: #111827;

            --background: #ffffff;
            --surface: #f9fafb;
            --surface-soft: #f3f4f6;
            --text: #111827;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --border-light: #f3f4f6;

            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .theme-dark {
            --background: #1f2937;
            --surface: #374151;
            --surface-soft: #4b5563;
            --text: #f9fafb;
            --text-muted: #d1d5db;
            --border: #4b5563;
            --border-light: #6b7280;
        }

        .theme-premium {
            --primary: #8b5cf6;
            --primary-dark: #7c3aed;
            --background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --surface: rgba(255, 255, 255, 0.95);
            --text: #1f2937;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--background);
            color: var(--text);
        }

        .sidebar {
            background-color: var(--surface);
            border-right: 1px solid var(--border);
        }

        .card {
            background-color: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: white;
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-outline {
            background-color: transparent;
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }

        .grid {
            display: grid;
            gap: 1rem;
        }

        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

        @media (min-width: 768px) {
            .md\\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .md\\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .md\\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #d1fae5;
            border-left-color: #10b981;
            color: #065f46;
        }

        .alert-warning {
            background-color: #fef3c7;
            border-left-color: #f59e0b;
            color: #92400e;
        }

        .alert-danger {
            background-color: #fee2e2;
            border-left-color: #ef4444;
            color: #991b1b;
        }

        .alert-info {
            background-color: #dbeafe;
            border-left-color: #3b82f6;
            color: #1e40af;
        }

        .stat-card {
            background-color: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
        }

        .page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text);
            margin: 0 0 0.5rem 0;
        }

        .page-subtitle {
            font-size: 1rem;
            color: var(--text-muted);
            margin: 0;
        }

        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            background-color: var(--surface-soft);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .button-group {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: var(--surface);
            border: 1px solid var(--border);
        }

        .toast {
            background-color: var(--surface);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50 md:hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 px-4 bg-blue-600">
                    <h1 class="text-xl font-bold text-white">{{ config('app.name', 'Gym Manager') }}</h1>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 overflow-y-auto">
                    <x-sidebar-nav :items="$sidebar" :currentRoute="Route::currentRouteName()"/>
                </nav>

                <!-- User Info -->
                @if(auth()->check())
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <x-avatar :name="auth()->user()->name" size="sm"/>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Content -->
        <div class="md:ml-64">
            <!-- Top Navigation -->
            <x-top-nav :user="auth()->user()" :notifications="$topNav['notifications'] ?? []"/>

            <!-- Page Content -->
            <main class="p-6">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <x-footer :links="$footer['links'] ?? []" :copyright="$footer['copyright'] ?? '© ' . date('Y') . ' ' . config('app.name', 'Gym Manager') . '. All rights reserved.'"/>
        </div>
    </div>

    <!-- Modals Container -->
    <div id="modals-container"></div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    @stack('scripts')

    <script>
        // Theme management
        function setTheme(theme) {
            document.documentElement.className = theme ? `theme-${theme}` : '';
            localStorage.setItem('theme', theme);
        }

        function getTheme() {
            return localStorage.getItem('theme') || 'light';
        }

        // Initialize theme
        setTheme(getTheme());

        // Sidebar toggle for mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebar && overlay) {
                const isOpen = sidebar.classList.contains('md:translate-x-0') || sidebar.classList.contains('translate-x-0');

                if (window.innerWidth < 768) {
                    if (isOpen) {
                        sidebar.classList.remove('translate-x-0');
                        sidebar.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                    } else {
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.classList.add('translate-x-0');
                        overlay.classList.remove('hidden');
                    }
                }
            }
        }

        // Global functions for components
        window.showModal = function(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        };

        window.hideModal = function(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        };

        window.showToast = function(message, type = 'info', duration = 5000) {
            const toastContainer = document.getElementById('toast-container');
            const toastId = 'toast-' + Date.now();

            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = 'toast';
            toast.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        ${type === 'success' ? '✓' : type === 'error' ? '✕' : type === 'warning' ? '⚠' : 'ℹ'}
                    </div>
                    <div class="ml-3 text-sm font-medium">
                        ${message}
                    </div>
                    <button type="button" class="ml-4 text-gray-400 hover:text-gray-600" onclick="hideToast('${toastId}')">
                        ✕
                    </button>
                </div>
            `;

            toastContainer.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.add('translate-x-0');
            }, 100);

            // Auto hide
            setTimeout(() => {
                hideToast(toastId);
            }, duration);
        };

        window.hideToast = function(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.remove('translate-x-0');
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.parentElement.removeChild(toast);
                    }
                }, 300);
            }
        };
    </script>
</body>
</html>