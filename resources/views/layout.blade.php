<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NovaCoin — Next-Gen Crypto Mining')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Syne:wght@400;500;600;700&family=JetBrains+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #F0B90B;
            --gold-dim: #c99a08;
            --gold-glow: rgba(240,185,11,0.25);
            --bg-void: #040508;
            --bg-deep: #07090f;
            --bg-card: #0d1117;
            --bg-card2: #111827;
            --border: rgba(240,185,11,0.15);
            --border-bright: rgba(240,185,11,0.4);
            --text-primary: #eef2ff;
            --text-muted: #6b7280;
            --text-dim: #374151;
            --green: #10b981;
            --red: #ef4444;
            --blue: #3b82f6;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Syne', sans-serif;
            background: var(--bg-void);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* GLOBAL NOISE TEXTURE */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: 0.35;
        }

        /* NAVBAR */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            height: 64px;
            background: rgba(4,5,8,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        .nav-logo {
            font-family: 'Orbitron', monospace;
            font-weight: 900;
            font-size: 1.25rem;
            color: var(--gold);
            letter-spacing: 0.1em;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-logo .dot {
            width: 8px; height: 8px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 12px var(--gold);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.8); }
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-links a:hover { color: var(--gold); }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.4rem;
            background: var(--gold);
            color: #000;
            font-family: 'Orbitron', monospace;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            text-decoration: none;
            clip-path: polygon(8px 0%, 100% 0%, calc(100% - 8px) 100%, 0% 100%);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #fff;
            box-shadow: 0 0 30px var(--gold-glow);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.4rem;
            background: transparent;
            color: var(--gold);
            font-family: 'Orbitron', monospace;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border: 1px solid var(--border-bright);
            cursor: pointer;
            text-decoration: none;
            clip-path: polygon(8px 0%, 100% 0%, calc(100% - 8px) 100%, 0% 100%);
            transition: all 0.2s;
        }

        .btn-ghost:hover {
            background: var(--gold-glow);
            border-color: var(--gold);
        }

        /* GRID BACKGROUND */
        .grid-bg {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(240,185,11,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(240,185,11,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .page-content {
            padding-top: 64px;
            min-height: 100vh;
        }

        /* CARDS */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.5;
        }

        /* FORM FIELDS */
        .field-group { margin-bottom: 1.25rem; }

        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .field-input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 2px;
            color: var(--text-primary);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .field-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px var(--gold-glow);
        }

        .field-input::placeholder { color: var(--text-dim); }

        select.field-input option { background: var(--bg-card2); }

        /* STATUS BADGE */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.75rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-radius: 2px;
        }

        .badge-green { background: rgba(16,185,129,0.1); color: var(--green); border: 1px solid rgba(16,185,129,0.3); }
        .badge-gold { background: rgba(240,185,11,0.1); color: var(--gold); border: 1px solid rgba(240,185,11,0.3); }
        .badge-red { background: rgba(239,68,68,0.1); color: var(--red); border: 1px solid rgba(239,68,68,0.3); }

        /* TICKER BAR */
        .ticker-bar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 0.4rem 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .ticker-inner {
            display: inline-flex;
            gap: 3rem;
            animation: ticker 30s linear infinite;
        }

        @keyframes ticker {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }

        .ticker-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
        }

        .ticker-item .sym { color: var(--gold); font-weight: 600; }
        .ticker-item .price { color: var(--text-primary); }
        .ticker-item .change-up { color: var(--green); }
        .ticker-item .change-down { color: var(--red); }

        /* SIDEBAR */
        .app-layout {
            display: grid;
            grid-template-columns: 220px 1fr;
            min-height: calc(100vh - 64px);
        }

        .sidebar {
            background: var(--bg-deep);
            border-right: 1px solid var(--border);
            padding: 1.5rem 0;
            position: sticky;
            top: 64px;
            height: calc(100vh - 64px);
            overflow-y: auto;
        }

        .sidebar-section {
            padding: 0.5rem 1rem;
            margin-bottom: 0.25rem;
        }

        .sidebar-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--text-dim);
            padding: 0 0.75rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.75rem;
            border-radius: 3px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.15s;
            margin-bottom: 0.15rem;
        }

        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(240,185,11,0.07);
            color: var(--gold);
            border-left: 2px solid var(--gold);
            padding-left: calc(0.75rem - 2px);
        }

        .sidebar-link svg { flex-shrink: 0; }

        .main-area { padding: 2rem; overflow-y: auto; }

        /* STAT CARD */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0; right: 0;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: var(--gold-glow);
            filter: blur(30px);
        }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
        }

        .stat-value {
            font-family: 'Orbitron', monospace;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gold);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-sub {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* SECTION HEADER */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .section-title {
            font-family: 'Orbitron', monospace;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-primary);
        }

        /* DIVIDER */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border-bright), transparent);
            margin: 1.5rem 0;
        }

        /* GLOW LINE */
        .glow-line {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 0 auto;
        }

        /* PROGRESS BAR */
        .progress-track {
            background: rgba(255,255,255,0.05);
            border-radius: 2px;
            height: 6px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--gold-dim), var(--gold));
            border-radius: 2px;
            position: relative;
            transition: width 0.5s ease;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            right: 0; top: 50%;
            transform: translateY(-50%);
            width: 10px; height: 10px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--gold);
        }

        /* TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .data-table th {
            text-align: left;
            padding: 0.75rem 1rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        .data-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            color: var(--text-primary);
        }

        .data-table tr:hover td { background: rgba(240,185,11,0.02); }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-bright); border-radius: 2px; }

        /* ANIMATIONS */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
        .delay-4 { animation-delay: 0.4s; opacity: 0; }
        .delay-5 { animation-delay: 0.5s; opacity: 0; }

        @yield('extra-styles')
    </style>
</head>
<body>
    <div class="grid-bg"></div>

    <!-- NAVBAR -->
    <nav>
        <a href="/" class="nav-logo">
            <div class="dot"></div>
            NOVA<span style="color:var(--text-muted)">COIN</span>
        </a>
        <ul class="nav-links">
            <li><a href="#">Markets</a></li>
            <li><a href="/mining">Mining</a></li>
            <li><a href="/withdraw">Exchange</a></li>
            <li><a href="#">About</a></li>
        </ul>
        <div style="display:flex;gap:0.75rem;align-items:center;">
            @yield('nav-actions')
        </div>
    </nav>

    <!-- TICKER -->
    <div style="position:fixed;top:64px;left:0;right:0;z-index:99;">
        <div class="ticker-bar">
            <div class="ticker-inner">
                <!-- Duplicated for infinite loop -->
                @php
                $tickers = [
                    ['NVC', '0.0842', '+12.4%', true],
                    ['BTC', '62,450.00', '+1.2%', true],
                    ['ETH', '3,210.50', '-0.8%', false],
                    ['BNB', '412.30', '+2.1%', true],
                    ['SOL', '148.70', '+5.3%', true],
                    ['USDT', '1.00', '0.0%', true],
                    ['ADA', '0.458', '-1.4%', false],
                    ['DOT', '7.82', '+3.2%', true],
                    ['NVC', '0.0842', '+12.4%', true],
                    ['BTC', '62,450.00', '+1.2%', true],
                    ['ETH', '3,210.50', '-0.8%', false],
                    ['BNB', '412.30', '+2.1%', true],
                    ['SOL', '148.70', '+5.3%', true],
                    ['USDT', '1.00', '0.0%', true],
                    ['ADA', '0.458', '-1.4%', false],
                    ['DOT', '7.82', '+3.2%', true],
                ];
                @endphp
                @foreach($tickers as $t)
                <div class="ticker-item">
                    <span class="sym">{{ $t[0] }}</span>
                    <span class="price">${{ $t[1] }}</span>
                    <span class="{{ $t[3] ? 'change-up' : 'change-down' }}">{{ $t[3] ? '▲' : '▼' }} {{ $t[2] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="page-content" style="padding-top: 96px;">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>