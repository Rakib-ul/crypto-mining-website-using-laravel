@extends('layout')

@section('title', 'Mine NovaCoin — NovaCoin')

@section('nav-actions')
    <div style="display:flex;align-items:center;gap:0.75rem;">
        <div class="badge badge-green">
            <span style="width:6px;height:6px;background:var(--green);border-radius:50%;display:inline-block;"></span>
            Mining Active
        </div>
        <div style="width:36px;height:36px;background:var(--gold-glow);border:1px solid var(--border-bright);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.7rem;font-weight:700;color:var(--gold);cursor:pointer;">R</div>
    </div>
@endsection

@section('extra-styles')
<style>
    /* MINING ORB */
    .mining-orb-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 0;
        position: relative;
    }

    .mining-orb {
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle at 35% 35%, rgba(240,185,11,0.15), rgba(240,185,11,0.02));
        border: 2px solid var(--border-bright);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        transition: all 0.3s;
        user-select: none;
    }

    .mining-orb::before {
        content: '';
        position: absolute;
        inset: -8px;
        border-radius: 50%;
        border: 1px solid var(--border);
        animation: orbRotate 8s linear infinite;
    }

    .mining-orb::after {
        content: '';
        position: absolute;
        inset: -16px;
        border-radius: 50%;
        border: 1px dashed rgba(240,185,11,0.15);
        animation: orbRotate 14s linear infinite reverse;
    }

    @keyframes orbRotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .mining-orb.mining {
        border-color: var(--gold);
        box-shadow: 0 0 40px var(--gold-glow), 0 0 80px rgba(240,185,11,0.1), inset 0 0 40px rgba(240,185,11,0.05);
        animation: miningPulse 1.5s ease-in-out infinite;
    }

    @keyframes miningPulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 40px var(--gold-glow), 0 0 80px rgba(240,185,11,0.1); }
        50% { transform: scale(1.02); box-shadow: 0 0 60px rgba(240,185,11,0.4), 0 0 120px rgba(240,185,11,0.15); }
    }

    .orb-label {
        font-family: 'Orbitron', monospace;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }

    .orb-value {
        font-family: 'Orbitron', monospace;
        font-size: 2rem;
        font-weight: 900;
        color: var(--gold);
        line-height: 1;
    }

    .orb-unit {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    .orb-action {
        font-family: 'Orbitron', monospace;
        font-size: 0.65rem;
        letter-spacing: 0.15em;
        color: var(--gold);
        margin-top: 0.75rem;
        text-transform: uppercase;
    }

    /* ORBIT DOTS */
    .orbit-container {
        position: absolute;
        width: 300px;
        height: 300px;
        pointer-events: none;
    }

    .orbit-dot {
        position: absolute;
        width: 8px;
        height: 8px;
        background: var(--gold);
        border-radius: 50%;
        box-shadow: 0 0 8px var(--gold);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .mining-active .orbit-dot {
        opacity: 1;
    }

    /* MINING STATS RING */
    .stats-ring {
        display: flex;
        gap: 2rem;
        justify-content: center;
        margin-top: 2rem;
    }

    .ring-stat {
        text-align: center;
    }

    .ring-stat-value {
        font-family: 'Orbitron', monospace;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--gold);
    }

    .ring-stat-label {
        font-size: 0.68rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-top: 0.2rem;
    }

    /* LOG TERMINAL */
    .terminal {
        background: #020304;
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 1rem;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        height: 180px;
        overflow-y: auto;
    }

    .log-line {
        padding: 0.15rem 0;
        color: var(--text-muted);
        opacity: 0;
        animation: fadeIn 0.3s forwards;
    }

    @keyframes fadeIn {
        to { opacity: 1; }
    }

    .log-line .ts { color: var(--text-dim); }
    .log-line .ev { color: var(--gold); }
    .log-line .ok { color: var(--green); }

    /* POWER LEVELS */
    .power-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .power-card {
        padding: 1rem;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .power-card:hover {
        border-color: var(--border-bright);
    }

    .power-card.active {
        border-color: var(--gold);
        background: rgba(240,185,11,0.05);
    }

    .power-level {
        font-family: 'Orbitron', monospace;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .power-rate {
        font-size: 0.78rem;
        color: var(--gold);
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .power-desc {
        font-size: 0.68rem;
        color: var(--text-muted);
    }

    /* Leaderboard */
    .rank-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.625rem 0.875rem;
        border-bottom: 1px solid rgba(255,255,255,0.03);
        transition: background 0.15s;
    }

    .rank-item:hover { background: rgba(240,185,11,0.02); }

    .rank-num {
        font-family: 'Orbitron', monospace;
        font-size: 0.75rem;
        font-weight: 700;
        width: 24px;
        text-align: center;
    }

    .rank-1 { color: #FFD700; }
    .rank-2 { color: #C0C0C0; }
    .rank-3 { color: #CD7F32; }

    /* Floating particles */
    .particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: var(--gold);
        border-radius: 50%;
        pointer-events: none;
        animation: floatUp 2s ease forwards;
        box-shadow: 0 0 6px var(--gold);
    }

    @keyframes floatUp {
        0% { opacity: 1; transform: translateY(0) scale(1); }
        100% { opacity: 0; transform: translateY(-80px) scale(0); }
    }
</style>
@endsection

@section('content')
<div class="app-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div style="padding:1rem;margin-bottom:1rem;border-bottom:1px solid var(--border);">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:42px;height:42px;background:linear-gradient(135deg,var(--gold-glow),rgba(240,185,11,0.1));border:1px solid var(--border-bright);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.8rem;font-weight:700;color:var(--gold);">R</div>
                <div>
                    <div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">Rafi Hassan</div>
                    <div style="font-size:0.7rem;color:var(--text-muted);">@rafi_miner</div>
                </div>
            </div>
        </div>

        <div class="sidebar-label">Main</div>
        <div class="sidebar-section">
            <a href="/dashboard" class="sidebar-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="/mining" class="sidebar-link active">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Mining
            </a>
            <a href="#" class="sidebar-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                Wallet
            </a>
            <a href="#" class="sidebar-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                Exchange
            </a>
        </div>

        <div class="sidebar-label" style="margin-top:0.5rem;">Mining Stats</div>
        <div style="margin:0 1rem;">
            <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:4px;padding:0.875rem;margin-bottom:0.75rem;">
                <div style="font-size:0.65rem;color:var(--text-dim);margin-bottom:0.35rem;letter-spacing:0.1em;text-transform:uppercase;">Session Earned</div>
                <div id="session-earned" style="font-family:'Orbitron',monospace;font-size:1.1rem;font-weight:700;color:var(--gold);">0.00</div>
                <div style="font-size:0.7rem;color:var(--text-muted);">NVC tokens</div>
            </div>

            <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:4px;padding:0.875rem;margin-bottom:0.75rem;">
                <div style="font-size:0.65rem;color:var(--text-dim);margin-bottom:0.35rem;letter-spacing:0.1em;text-transform:uppercase;">Daily Limit</div>
                <div style="font-family:'Orbitron',monospace;font-size:0.9rem;font-weight:700;color:var(--text-primary);">847 / 1,250</div>
                <div class="progress-track" style="margin-top:0.5rem;">
                    <div class="progress-fill" id="daily-progress" style="width:67.8%;"></div>
                </div>
                <div style="font-size:0.68rem;color:var(--text-dim);margin-top:0.35rem;">403 NVC remaining today</div>
            </div>

            <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:4px;padding:0.875rem;">
                <div style="font-size:0.65rem;color:var(--text-dim);margin-bottom:0.35rem;letter-spacing:0.1em;text-transform:uppercase;">Hash Rate</div>
                <div id="hash-rate" style="font-family:'JetBrains Mono',monospace;font-size:0.95rem;font-weight:600;color:var(--green);">-- MH/s</div>
                <div id="hash-status" style="font-size:0.7rem;color:var(--text-muted);">Not mining</div>
            </div>
        </div>
    </aside>

    <!-- MAIN MINING AREA -->
    <main class="main-area">
        <div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;">

            <!-- LEFT: MAIN MINING PANEL -->
            <div>
                <!-- Page header -->
                <div style="margin-bottom:1.5rem;" class="animate-in">
                    <div style="font-size:0.72rem;letter-spacing:0.15em;color:var(--text-muted);text-transform:uppercase;margin-bottom:0.25rem;">Proof of Activity</div>
                    <h1 style="font-family:'Orbitron',monospace;font-size:1.6rem;font-weight:700;color:var(--text-primary);">
                        NovaCoin <span style="color:var(--gold);">Mining</span>
                    </h1>
                </div>

                <!-- MINING ORB PANEL -->
                <div class="card animate-in delay-1" style="text-align:center;position:relative;overflow:visible;">
                    <div class="mining-orb-wrap" id="mining-wrap">
                        <!-- Orbiting particles (shown when mining) -->
                        <div class="orbit-container" id="orbit" style="display:flex;align-items:center;justify-content:center;">
                            <div class="orbit-dot" id="od1" style="top:10px;left:50%;transform:translateX(-50%);"></div>
                            <div class="orbit-dot" id="od2" style="bottom:10px;right:20%;"></div>
                            <div class="orbit-dot" id="od3" style="left:10px;top:50%;transform:translateY(-50%);"></div>
                        </div>

                        <div class="mining-orb" id="mining-orb" onclick="toggleMining()">
                            <div class="orb-label" id="orb-label">Session Tokens</div>
                            <div class="orb-value" id="orb-value">0.00</div>
                            <div class="orb-unit">NVC</div>
                            <div class="orb-action" id="orb-action">⬡ TAP TO MINE</div>
                        </div>
                    </div>

                    <!-- Stats ring -->
                    <div class="stats-ring animate-in delay-2">
                        <div class="ring-stat">
                            <div class="ring-stat-value" id="stat-rate">0</div>
                            <div class="ring-stat-label">NVC/hour</div>
                        </div>
                        <div style="width:1px;background:var(--border);"></div>
                        <div class="ring-stat">
                            <div class="ring-stat-value" id="stat-blocks">0</div>
                            <div class="ring-stat-label">Blocks Found</div>
                        </div>
                        <div style="width:1px;background:var(--border);"></div>
                        <div class="ring-stat">
                            <div class="ring-stat-value" id="stat-time">00:00</div>
                            <div class="ring-stat-label">Session Time</div>
                        </div>
                        <div style="width:1px;background:var(--border);"></div>
                        <div class="ring-stat">
                            <div class="ring-stat-value" id="stat-usd">$0.00</div>
                            <div class="ring-stat-label">USD Value</div>
                        </div>
                    </div>

                    <!-- Daily cap progress -->
                    <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--border);">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                            <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-muted);">Daily Mining Cap</div>
                            <div style="font-family:'Orbitron',monospace;font-size:0.85rem;font-weight:700;color:var(--gold);" id="cap-label">847 / 1,250 NVC</div>
                        </div>
                        <div class="progress-track" style="height:10px;">
                            <div class="progress-fill" id="cap-progress" style="width:67.8%;"></div>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:0.7rem;color:var(--text-dim);margin-top:0.5rem;">
                            <span>Daily reset in <span id="reset-timer" style="color:var(--gold);">14:22:37</span></span>
                            <span>403 NVC remaining</span>
                        </div>
                    </div>
                </div>

                <!-- POWER LEVELS -->
                <div class="card animate-in delay-3" style="margin-top:1rem;">
                    <div class="section-header">
                        <div class="section-title">Mining Power</div>
                        <div class="badge badge-gold">Standard Plan</div>
                    </div>
                    <div class="power-grid">
                        <div class="power-card" onclick="setPower(this, 'eco')">
                            <div class="power-level">ECO</div>
                            <div class="power-rate">125 NVC/h</div>
                            <div class="power-desc">Low CPU · Browser friendly</div>
                        </div>
                        <div class="power-card active" onclick="setPower(this, 'std')">
                            <div class="power-level">STD</div>
                            <div class="power-rate">250 NVC/h</div>
                            <div class="power-desc">Balanced · Recommended</div>
                        </div>
                        <div class="power-card" onclick="setPower(this, 'max')">
                            <div class="power-level">MAX</div>
                            <div class="power-rate" style="color:var(--green);">500 NVC/h</div>
                            <div class="power-desc">High performance · Pro</div>
                        </div>
                    </div>
                    <div style="margin-top:0.875rem;padding:0.75rem;background:rgba(240,185,11,0.04);border:1px solid var(--border);border-radius:3px;font-size:0.75rem;color:var(--text-muted);">
                        💡 Upgrade to Pro to unlock MAX mining speed and 1,500 NVC/day cap.
                        <a href="#" style="color:var(--gold);text-decoration:none;font-weight:600;">Upgrade →</a>
                    </div>
                </div>

                <!-- TERMINAL LOG -->
                <div class="card animate-in delay-4" style="margin-top:1rem;">
                    <div class="section-header">
                        <div class="section-title">Mining Log</div>
                        <div class="badge badge-green" id="log-status">Idle</div>
                    </div>
                    <div class="terminal" id="terminal">
                        <div class="log-line"><span class="ts">[14:32:01]</span> <span class="ev">SYSTEM</span> NovaCoin mining client v2.4.1 initialized</div>
                        <div class="log-line"><span class="ts">[14:32:01]</span> <span class="ok">OK</span> &nbsp;&nbsp;&nbsp;&nbsp;Wallet connected: 0x8f3a...9c12</div>
                        <div class="log-line"><span class="ts">[14:32:02]</span> <span class="ok">OK</span> &nbsp;&nbsp;&nbsp;&nbsp;KYC verified · Mining pool: NOVA-POOL-01</div>
                        <div class="log-line"><span class="ts">[14:32:02]</span> <span class="ev">READY</span> Awaiting user input to begin session...</div>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL -->
            <div style="display:flex;flex-direction:column;gap:1rem;">
                <!-- NVC Price -->
                <div class="card animate-in delay-1">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                        <div class="section-title">NVC / USDT</div>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Binance_Logo.svg/120px-Binance_Logo.svg.png"
                             alt="Binance" style="height:16px;opacity:0.8;">
                    </div>
                    <div style="font-family:'Orbitron',monospace;font-size:2rem;font-weight:900;color:var(--gold);">$0.0842</div>
                    <div style="font-size:0.8rem;color:var(--green);margin-top:0.25rem;">▲ +12.4% (24h)</div>

                    <div class="divider"></div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;font-size:0.75rem;">
                        <div>
                            <div style="color:var(--text-dim);margin-bottom:0.2rem;font-size:0.68rem;letter-spacing:0.1em;text-transform:uppercase;">24h High</div>
                            <div style="font-family:'JetBrains Mono',monospace;color:var(--green);">$0.0891</div>
                        </div>
                        <div>
                            <div style="color:var(--text-dim);margin-bottom:0.2rem;font-size:0.68rem;letter-spacing:0.1em;text-transform:uppercase;">24h Low</div>
                            <div style="font-family:'JetBrains Mono',monospace;color:var(--red);">$0.0741</div>
                        </div>
                        <div>
                            <div style="color:var(--text-dim);margin-bottom:0.2rem;font-size:0.68rem;letter-spacing:0.1em;text-transform:uppercase;">Volume</div>
                            <div style="font-family:'JetBrains Mono',monospace;color:var(--text-muted);">$2.4M</div>
                        </div>
                        <div>
                            <div style="color:var(--text-dim);margin-bottom:0.2rem;font-size:0.68rem;letter-spacing:0.1em;text-transform:uppercase;">Market Cap</div>
                            <div style="font-family:'JetBrains Mono',monospace;color:var(--text-muted);">$320M</div>
                        </div>
                    </div>
                </div>

                <!-- Leaderboard -->
                <div class="card animate-in delay-2" style="padding:0;">
                    <div style="padding:1rem 1rem 0.75rem;border-bottom:1px solid var(--border);">
                        <div class="section-title">Top Miners Today</div>
                    </div>
                    @php
                    $leaders = [
                        ['crypto_king99', 'US', '1,250', 1],
                        ['satoshi_bd', 'BD', '1,250', 2],
                        ['nova_whale', 'SG', '1,249', 3],
                        ['miner_leo', 'AU', '1,247', null],
                        ['you → Rafi_H', 'BD', '847', null],
                        ['blockchain_k', 'IN', '843', null],
                        ['crypto_sarah', 'CA', '821', null],
                    ];
                    @endphp
                    @foreach($leaders as $i => $l)
                    <div class="rank-item" style="{{ $l[0] === 'you → Rafi_H' ? 'background:rgba(240,185,11,0.04);border-left:2px solid var(--gold);' : '' }}">
                        <div class="rank-num {{ $l[3] === 1 ? 'rank-1' : ($l[3] === 2 ? 'rank-2' : ($l[3] === 3 ? 'rank-3' : '')) }}">
                            @if($l[3]) {{ ['🥇','🥈','🥉'][$l[3]-1] }} @else {{ $i + 1 }} @endif
                        </div>
                        <div style="width:28px;height:28px;background:{{ $l[0] === 'you → Rafi_H' ? 'var(--gold-glow);border:1px solid var(--border-bright)' : 'rgba(255,255,255,0.04)' }};border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.55rem;font-weight:700;color:{{ $l[0] === 'you → Rafi_H' ? 'var(--gold)' : 'var(--text-muted)' }};">
                            {{ strtoupper(substr($l[0], 0, 1)) }}
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:0.78rem;font-weight:{{ $l[0] === 'you → Rafi_H' ? '700' : '500' }};color:{{ $l[0] === 'you → Rafi_H' ? 'var(--gold)' : 'var(--text-primary)' }};">{{ $l[0] }}</div>
                            <div style="font-size:0.65rem;color:var(--text-dim);">{{ $l[1] }}</div>
                        </div>
                        <div style="font-family:'JetBrains Mono',monospace;font-size:0.78rem;color:var(--text-muted);">{{ $l[2] }}</div>
                    </div>
                    @endforeach
                </div>

                <!-- Binance Integration -->
                <div style="background:linear-gradient(135deg,#1a1200 0%,#0a0800 100%);border:1px solid rgba(240,185,11,0.3);border-radius:4px;padding:1.25rem;" class="animate-in delay-3">
                    <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.875rem;">
                        <div style="width:36px;height:36px;background:#F0B90B;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="font-family:'Orbitron',monospace;font-size:0.55rem;font-weight:900;color:#000;">BNB</span>
                        </div>
                        <div>
                            <div style="font-size:0.85rem;font-weight:700;color:var(--gold);">Binance Exchange</div>
                            <div class="badge badge-green" style="margin-top:0.2rem;">Connected</div>
                        </div>
                    </div>
                    <div style="font-size:0.78rem;color:var(--text-muted);line-height:1.6;margin-bottom:1rem;">
                        Your mined NVC is automatically convertible to USDT or BTC on Binance with real-time pricing.
                    </div>
                    <button class="btn-primary" style="width:100%;justify-content:center;padding:0.7rem;font-size:0.72rem;">
                        Convert NVC → USDT Now →
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
    let isMining = false;
    let sessionTokens = 0;
    let sessionSeconds = 0;
    let blocks = 0;
    let miningInterval, timerInterval, logInterval;
    let currentRate = 250; // NVC per hour
    const dailyMined = 847;
    const dailyCap = 1250;
    let dailyProgress = dailyMined;

    const orb = document.getElementById('mining-orb');
    const orbValue = document.getElementById('orb-value');
    const orbAction = document.getElementById('orb-action');
    const orbLabel = document.getElementById('orb-label');
    const terminal = document.getElementById('terminal');
    const logStatus = document.getElementById('log-status');

    function toggleMining() {
        if (dailyProgress >= dailyCap) {
            addLog('LIMIT', 'Daily mining cap reached. Resets in ' + document.getElementById('reset-timer').textContent, 'ev');
            return;
        }
        isMining = !isMining;
        if (isMining) startMining();
        else stopMining();
    }

    function startMining() {
        orb.classList.add('mining');
        orbAction.textContent = '■ STOP MINING';
        orbLabel.textContent = 'Mining Active';
        logStatus.textContent = 'Mining';
        logStatus.className = 'badge badge-green';

        document.getElementById('hash-rate').textContent = (currentRate / 3.6).toFixed(1) + ' MH/s';
        document.getElementById('hash-status').textContent = 'Mining...';
        document.getElementById('stat-rate').textContent = currentRate;

        addLog('START', 'Mining session started · Power: ' + currentRate + ' NVC/h', 'ok');
        addLog('INFO ', 'Connected to NOVA-POOL-01 · Difficulty: 4.2T', 'ev');

        // Mining ticker
        miningInterval = setInterval(() => {
            const earned = currentRate / 3600;
            if (dailyProgress + earned >= dailyCap) {
                sessionTokens += (dailyCap - dailyProgress);
                dailyProgress = dailyCap;
                updateUI();
                stopMining();
                addLog('LIMIT', 'Daily cap of ' + dailyCap + ' NVC reached! Come back tomorrow.', 'ev');
                return;
            }
            sessionTokens += earned;
            dailyProgress += earned;
            updateUI();

            // Random block find
            if (Math.random() < 0.003) {
                blocks++;
                const reward = (Math.random() * 5 + 1).toFixed(2);
                addLog('BLOCK', '⬡ Block found! Reward: +' + reward + ' NVC (Block #' + (1420000 + blocks) + ')', 'ok');
                spawnParticles();
            }
        }, 100);

        // Timer
        timerInterval = setInterval(() => {
            sessionSeconds++;
            const m = String(Math.floor(sessionSeconds/60)).padStart(2,'0');
            const s = String(sessionSeconds % 60).padStart(2,'0');
            document.getElementById('stat-time').textContent = m + ':' + s;
        }, 1000);

        // Periodic log
        const logMessages = [
            ['HASH ', 'Submitted share to pool · Difficulty accepted', 'ok'],
            ['SYNC ', 'Network sync OK · Peers: 142 · Latency: 12ms', 'ev'],
            ['VALID', 'Share validated by pool server', 'ok'],
            ['QUEUE', 'Transaction batch queued for next block', 'ev'],
        ];
        let logIdx = 0;
        logInterval = setInterval(() => {
            const msg = logMessages[logIdx % logMessages.length];
            addLog(msg[0], msg[1], msg[2]);
            logIdx++;
        }, 4000);
    }

    function stopMining() {
        isMining = false;
        orb.classList.remove('mining');
        orbAction.textContent = '⬡ TAP TO MINE';
        orbLabel.textContent = 'Session Tokens';
        logStatus.textContent = 'Idle';
        logStatus.className = 'badge badge-gold';
        document.getElementById('hash-rate').textContent = '-- MH/s';
        document.getElementById('hash-status').textContent = 'Not mining';
        document.getElementById('stat-rate').textContent = '0';

        clearInterval(miningInterval);
        clearInterval(timerInterval);
        clearInterval(logInterval);

        addLog('STOP ', 'Session ended · Earned: ' + sessionTokens.toFixed(2) + ' NVC', 'ev');
    }

    function updateUI() {
        orbValue.textContent = sessionTokens.toFixed(2);
        document.getElementById('session-earned').textContent = sessionTokens.toFixed(2);
        document.getElementById('stat-blocks').textContent = blocks;
        document.getElementById('stat-usd').textContent = '$' + (sessionTokens * 0.0842).toFixed(2);

        const pct = Math.min((dailyProgress / dailyCap) * 100, 100);
        document.getElementById('cap-progress').style.width = pct + '%';
        document.getElementById('daily-progress').style.width = pct + '%';
        document.getElementById('cap-label').textContent = Math.floor(dailyProgress) + ' / ' + dailyCap + ' NVC';
    }

    function addLog(tag, msg, cls) {
        const now = new Date();
        const ts = now.toTimeString().slice(0,8);
        const line = document.createElement('div');
        line.className = 'log-line';
        line.innerHTML = `<span class="ts">[${ts}]</span> <span class="${cls}">${tag}</span> ${msg}`;
        terminal.appendChild(line);
        terminal.scrollTop = terminal.scrollHeight;

        // Keep log short
        while (terminal.children.length > 20) {
            terminal.removeChild(terminal.firstChild);
        }
    }

    function setPower(el, level) {
        document.querySelectorAll('.power-card').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
        const rates = { eco: 125, std: 250, max: 500 };
        currentRate = rates[level];
        document.getElementById('hash-rate').textContent = isMining ? (currentRate / 3.6).toFixed(1) + ' MH/s' : '-- MH/s';
        document.getElementById('stat-rate').textContent = isMining ? currentRate : '0';
        if (isMining) {
            clearInterval(miningInterval);
            addLog('POWER', 'Mining power changed to ' + level.toUpperCase() + ' (' + currentRate + ' NVC/h)', 'ev');
            miningInterval = setInterval(() => {
                const earned = currentRate / 3600;
                sessionTokens += earned;
                dailyProgress = Math.min(dailyProgress + earned, dailyCap);
                updateUI();
            }, 100);
        }
    }

    function spawnParticles() {
        const rect = orb.getBoundingClientRect();
        for (let i = 0; i < 8; i++) {
            setTimeout(() => {
                const p = document.createElement('div');
                p.className = 'particle';
                p.style.left = (rect.left + rect.width/2 + (Math.random()-0.5)*60) + 'px';
                p.style.top = (rect.top + rect.height/2 + (Math.random()-0.5)*60) + 'px';
                p.style.position = 'fixed';
                p.style.animationDuration = (1 + Math.random()) + 's';
                document.body.appendChild(p);
                setTimeout(() => p.remove(), 2000);
            }, i * 80);
        }
    }

    // Reset timer countdown
    let resetSeconds = 14 * 3600 + 22 * 60 + 37;
    setInterval(() => {
        resetSeconds = Math.max(0, resetSeconds - 1);
        const h = String(Math.floor(resetSeconds / 3600)).padStart(2, '0');
        const m = String(Math.floor((resetSeconds % 3600) / 60)).padStart(2, '0');
        const s = String(resetSeconds % 60).padStart(2, '0');
        const el = document.getElementById('reset-timer');
        if (el) el.textContent = h + ':' + m + ':' + s;
    }, 1000);
</script>
@endsection