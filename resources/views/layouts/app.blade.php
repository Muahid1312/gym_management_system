<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            color-scheme: dark;
            font-family: 'Inter', sans-serif;
            --bg: #0f172a;
            --surface: #111827;
            --surface-soft: #1f2937;
            --surface-light: #374151;
            --text: #e2e8f0;
            --muted: #94a3b8;
            --accent: #eab308;
            --accent-soft: #facc15;
            --border: rgba(148,163,184,0.18);
            --button: #f97316;
            --button-strong: #ea580c;
        }

        * { box-sizing: border-box; }

        body { margin: 0; min-height: 100vh; background: radial-gradient(circle at top, rgba(234,179,8,0.18), transparent 35%), linear-gradient(180deg, #020617 0%, #0f172a 100%); color: var(--text); }

        .navbar {
            background: rgba(15,23,42,0.96);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            color: white;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar .brand {
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--accent);
            font-size: 0.95rem;
        }

        .navbar-links {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .navbar a {
            color: var(--text);
            text-decoration: none;
            font-size: 0.95rem;
            padding: 10px 12px;
            border-radius: 999px;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .navbar a:hover {
            background: rgba(255,255,255,0.08);
            color: white;
        }

        .container {
            max-width: 1180px;
            margin: 28px auto;
            padding: 0 18px 34px;
        }

        .card {
            background: rgba(15,23,42,0.88);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 20px;
            padding: 26px;
            box-shadow: 0 30px 80px rgba(15,23,42,0.25);
            margin-bottom: 24px;
        }

        .card.hero {
            display: grid;
            gap: 16px;
            padding: 32px;
            border-color: rgba(234,179,8,0.35);
            background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(15,23,42,0.95));
        }

        .page-title {
            margin: 0 0 10px;
            font-size: clamp(1.8rem, 2.6vw, 2.8rem);
            letter-spacing: -0.03em;
        }

        .subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 1rem;
        }

        .grid { display: grid; gap: 22px; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }

        .stat-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 18px;
            padding: 22px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(234,179,8,0.18), transparent 38%);
            pointer-events: none;
        }

        .stat-card h3,
        .stat-card p { position: relative; z-index: 1; }

        .stat-card h3 { font-size: 0.95rem; letter-spacing: 0.05em; text-transform: uppercase; color: var(--muted); margin-bottom: 14px; }
        .stat-card p { font-size: 2.2rem; margin: 0; color: white; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
            background: rgba(255,255,255,0.03);
            border-radius: 16px;
            overflow: hidden;
        }

        th, td {
            padding: 16px 14px;
            text-align: left;
            color: var(--text);
        }

        th {
            background: rgba(255,255,255,0.06);
            color: var(--muted);
            text-transform: uppercase;
            font-size: 0.82rem;
            letter-spacing: 0.08em;
        }

        tr:nth-child(even) td { background: rgba(255,255,255,0.03); }

        .button, .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 18px;
            border-radius: 999px;
            text-decoration: none;
            color: white;
            background: linear-gradient(135deg, var(--button), var(--button-strong));
            border: 1px solid rgba(255,255,255,0.12);
            box-shadow: 0 12px 30px rgba(249,115,22,0.16);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
            font-weight: 600;
            letter-spacing: 0.03em;
        }

        .button:hover, .btn:hover { transform: translateY(-1px); box-shadow: 0 20px 35px rgba(249,115,22,0.22); }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 18px;
        }

        .alert {
            padding: 16px 18px;
            border-radius: 16px;
            margin-bottom: 22px;
            background: rgba(234,179,8,0.12);
            color: #f8f2d0;
            border: 1px solid rgba(234,179,8,0.2);
        }

        .alert-success { background: rgba(16,185,129,0.12); color: #d1fae5; border-color: rgba(16,185,129,0.25); }

        .form-group { margin-bottom: 20px; }

        label { display: block; margin-bottom: 8px; font-weight: 700; color: var(--text); }

        input, select, textarea {
            width: 100%;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.04);
            color: var(--text);
            font-size: 0.98rem;
            outline: none;
        }

        input:focus, select:focus, textarea:focus { border-color: rgba(234,179,8,0.45); box-shadow: 0 0 0 4px rgba(234,179,8,0.1); }

        textarea { min-height: 120px; resize: vertical; }

        .footer {
            text-align: center;
            padding: 22px 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .navbar { flex-wrap: wrap; justify-content: center; }
            .navbar-links { justify-content: center; }
            .card.hero { padding: 24px; }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a>
        <a href="{{ route('members.index') }}">{{ __('messages.members') }}</a>
        <a href="{{ route('plans.index') }}">{{ __('messages.plans') }}</a>
        <a href="{{ route('payments.index') }}">{{ __('messages.payments') }}</a>
        <a href="{{ route('reports.index') }}">{{ __('messages.reports') }}</a>
        <a href="{{ route('attendance.index') }}">{{ __('messages.attendance') }}</a>
    </nav>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert" style="background:#fee2e2; color:#7f1d1d;">
                <strong>There are validation errors:</strong>
                <ul style="margin: 10px 0 0 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
    <footer class="footer">Gym Management System • Simple Laravel solution</footer>
</body>
</html>
