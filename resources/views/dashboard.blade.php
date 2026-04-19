@extends('layout')

@section('title', 'Dashboard — NovaCoin')

@section('nav-actions')
    <div style="display:flex;align-items:center;gap:0.75rem;">
        <div class="badge badge-green">
            <span style="width:6px;height:6px;background:var(--green);border-radius:50%;display:inline-block;"></span>
            Mining Active
        </div>
        <div style="width:36px;height:36px;background:var(--gold-glow);border:1px solid var(--border-bright);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.7rem;font-weight:700;color:var(--gold);cursor:pointer;">
            R
        </div>
    </div>
@endsection

@section('extra-styles')
<style>
    .chart-area {
        height: 180px;
        position: relative;
        overflow: hidden;
    }

    .chart-svg {
        width: 100%;
        height: 100%;
    }

    .exchange-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--border);
        border-radius: 4px;
        margin-bottom: 0.75rem;
        transition: all 0.2s;
        cursor: pointer;
    }

    .exchange-row:hover {
        border-color: var(--border-bright);
        background: rgba(240,185,11,0.03);
    }

    .activity-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .notification-item {
        display: flex;
        gap: 0.75rem;
        padding: 0.875rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        align-items: flex-start;
    }

    .notif-icon {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Mini sparkline */
    @keyframes drawLine {
        from { stroke-dashoffset: 1000; }
        to { stroke-dashoffset: 0; }
    }

    .sparkline-path {
        stroke-dasharray: 1000;
        stroke-dashoffset: 1000;
        animation: drawLine 1.5s ease forwards;
        animation-delay: 0.5s;
    }
</style>
@endsection

@section('content')
<div class="app-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <!-- User Info -->
        <div style="padding:1rem;margin-bottom:1rem;border-bottom:1px solid var(--border);">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <div style="width:42px;height:42px;background:linear-gradient(135deg,var(--gold-glow),rgba(240,185,11,0.1));border:1px solid var(--border-bright);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.8rem;font-weight:700;color:var(--gold);">R</div>
                <div>
                    <div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">Rafi Hassan</div>
                    <div style="font-size:0.7rem;color:var(--text-muted);">@rafi_miner</div>
                </div>
            </div>
            <div style="margin-top:0.75rem;">
                <div class="badge badge-green" style="font-size:0.65rem;">✓ KYC Verified</div>
            </div>
        </div>

        <div class="sidebar-label">Main</div>
        <div class="sidebar-section">
            <a href="/dashboard" class="sidebar-link active">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <a href="/mining" class="sidebar-link">
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

        <div class="sidebar-label" style="margin-top:0.5rem;">Account</div>
        <div class="sidebar-section">
            <a href="#" class="sidebar-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Profile
            </a>
            <a href="#" class="sidebar-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M5.34 18.66l-1.41 1.41M12 2v2M12 20v2M4.93 4.93l1.41 1.41M18.66 18.66l1.41 1.41M2 12h2M20 12h2"/></svg>
                Settings
            </a>
            <a href="#" class="sidebar-link">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                Sign Out
            </a>
        </div>

        <!-- Daily mining progress in sidebar -->
        <div style="margin:1rem;padding:0.875rem;background:var(--bg-card);border:1px solid var(--border);border-radius:4px;">
            <div style="font-size:0.65rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-muted);margin-bottom:0.5rem;">Today's Mining</div>
            <div style="font-family:'Orbitron',monospace;font-size:1rem;font-weight:700;color:var(--gold);margin-bottom:0.5rem;">847.3 NVC</div>
            <div class="progress-track">
                <div class="progress-fill" style="width:67%;"></div>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:0.68rem;color:var(--text-dim);margin-top:0.35rem;">
                <span>847 / 1,250</span>
                <span>67%</span>
            </div>
        </div>
    </aside>

    <!-- MAIN DASHBOARD -->
    <main class="main-area">
        <!-- Header -->
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;" class="animate-in">
            <div>
                <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:0.25rem;letter-spacing:0.1em;">GOOD MORNING</div>
                <h1 style="font-family:'Orbitron',monospace;font-size:1.5rem;font-weight:700;color:var(--text-primary);">Rafi Hassan <span style="color:var(--gold);">⬡</span></h1>
            </div>
            <div style="display:flex;gap:0.75rem;">
                <a href="/mining" class="btn-primary">⬡ Start Mining</a>
                <button class="btn-ghost">↑ Withdraw</button>
            </div>
        </div>

        <!-- STAT CARDS -->
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem;">
            <div class="stat-card animate-in delay-1">
                <div class="stat-label">NVC Balance</div>
                <div class="stat-value">12,847</div>
                <div class="stat-sub">≈ $1,081.72 USD</div>
            </div>
            <div class="stat-card animate-in delay-2">
                <div class="stat-label">Total Mined</div>
                <div class="stat-value">38,291</div>
                <div class="stat-sub">Since Jan 2024</div>
            </div>
            <div class="stat-card animate-in delay-3">
                <div class="stat-label">Today's Earnings</div>
                <div class="stat-value" style="color:var(--green);">847.3</div>
                <div class="stat-sub" style="color:var(--green);">↑ +12% vs yesterday</div>
            </div>
            <div class="stat-card animate-in delay-4">
                <div class="stat-label">USD Value</div>
                <div class="stat-value">$1,081</div>
                <div class="stat-sub">NVC @ $0.0842</div>
            </div>
        </div>

        <!-- CHART + EXCHANGE -->
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:1rem;margin-bottom:2rem;">
            <!-- Mining Chart -->
            <div class="card animate-in delay-2">
                <div class="section-header">
                    <div class="section-title">Mining History</div>
                    <div style="display:flex;gap:0.5rem;">
                        <button style="padding:0.3rem 0.75rem;background:var(--gold);color:#000;border:none;border-radius:2px;font-family:'Orbitron',monospace;font-size:0.65rem;font-weight:700;cursor:pointer;">7D</button>
                        <button style="padding:0.3rem 0.75rem;background:transparent;color:var(--text-muted);border:1px solid var(--border);border-radius:2px;font-family:'Orbitron',monospace;font-size:0.65rem;cursor:pointer;">30D</button>
                        <button style="padding:0.3rem 0.75rem;background:transparent;color:var(--text-muted);border:1px solid var(--border);border-radius:2px;font-family:'Orbitron',monospace;font-size:0.65rem;cursor:pointer;">ALL</button>
                    </div>
                </div>
                <div class="chart-area">
                    <svg class="chart-svg" viewBox="0 0 600 160" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#F0B90B" stop-opacity="0.3"/>
                                <stop offset="100%" stop-color="#F0B90B" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <!-- Grid lines -->
                        <line x1="0" y1="40" x2="600" y2="40" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                        <line x1="0" y1="80" x2="600" y2="80" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                        <line x1="0" y1="120" x2="600" y2="120" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                        <!-- Area -->
                        <path d="M0,130 L60,110 L120,90 L180,105 L240,70 L300,55 L360,75 L420,45 L480,30 L540,20 L600,15 L600,160 L0,160 Z"
                              fill="url(#chartGrad)"/>
                        <!-- Line -->
                        <path class="sparkline-path"
                              d="M0,130 L60,110 L120,90 L180,105 L240,70 L300,55 L360,75 L420,45 L480,30 L540,20 L600,15"
                              fill="none" stroke="#F0B90B" stroke-width="2"/>
                        <!-- Dots -->
                        <circle cx="600" cy="15" r="4" fill="#F0B90B"/>
                        <circle cx="420" cy="45" r="3" fill="#F0B90B" opacity="0.6"/>
                        <circle cx="240" cy="70" r="3" fill="#F0B90B" opacity="0.6"/>
                    </svg>
                </div>
                <div style="display:flex;justify-content:space-between;font-family:'JetBrains Mono',monospace;font-size:0.68rem;color:var(--text-dim);padding-top:0.5rem;">
                    <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                </div>
            </div>

            <!-- Exchange Panel -->
            <div class="card animate-in delay-3">
                <div class="section-header">
                    <div class="section-title">Quick Convert</div>
                </div>
                <div style="background:rgba(240,185,11,0.04);border:1px solid var(--border);border-radius:4px;padding:0.875rem;margin-bottom:0.75rem;">
                    <div style="font-size:0.68rem;color:var(--text-muted);margin-bottom:0.4rem;">FROM</div>
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <div style="width:28px;height:28px;background:var(--gold-glow);border:1px solid var(--border-bright);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.55rem;font-weight:700;color:var(--gold);">NVC</div>
                        <input type="number" value="1000" style="flex:1;background:transparent;border:none;outline:none;font-family:'Orbitron',monospace;font-size:1.2rem;font-weight:700;color:var(--text-primary);">
                    </div>
                </div>
                <div style="text-align:center;margin:-4px 0;z-index:1;position:relative;">
                    <div style="width:28px;height:28px;background:var(--bg-card2);border:1px solid var(--border-bright);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;color:var(--gold);font-size:0.75rem;cursor:pointer;">⇅</div>
                </div>
                <div style="background:rgba(255,255,255,0.02);border:1px solid var(--border);border-radius:4px;padding:0.875rem;margin-bottom:0.75rem;">
                    <div style="font-size:0.68rem;color:var(--text-muted);margin-bottom:0.4rem;">TO (USDT)</div>
                    <div style="font-family:'Orbitron',monospace;font-size:1.2rem;font-weight:700;color:var(--green);">$84.20</div>
                </div>

                <div style="font-size:0.72rem;color:var(--text-dim);margin-bottom:1rem;text-align:center;">
                    1 NVC = $0.0842 USDT · Via Binance
                </div>

                <!-- Exchange logos -->
                <div class="exchange-row">
                    <div style="width:32px;height:32px;background:#F0B90B;border-radius:6px;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.55rem;font-weight:900;color:#000;flex-shrink:0;">BNB</div>
                    <div style="flex:1;">
                        <div style="font-size:0.8rem;font-weight:600;color:var(--text-primary);">Binance</div>
                        <div style="font-size:0.7rem;color:var(--text-muted);">Best rate · 0% fee</div>
                    </div>
                    <div class="badge badge-green">Best</div>
                </div>

                <div class="exchange-row" style="opacity:0.6;">
                    <div style="width:32px;height:32px;background:#0052FF;border-radius:6px;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.5rem;font-weight:900;color:#fff;flex-shrink:0;">CB</div>
                    <div style="flex:1;">
                        <div style="font-size:0.8rem;font-weight:600;color:var(--text-primary);">Coinbase</div>
                        <div style="font-size:0.7rem;color:var(--text-muted);">1.5% fee</div>
                    </div>
                </div>

                <button class="btn-primary" style="width:100%;justify-content:center;padding:0.75rem;font-size:0.75rem;">
                    Convert via Binance →
                </button>
            </div>
        </div>

        <!-- BOTTOM ROW -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <!-- Transaction History -->
            <div class="card animate-in delay-3">
                <div class="section-header">
                    <div class="section-title">Recent Transactions</div>
                    <a href="#" style="font-size:0.72rem;color:var(--gold);text-decoration:none;">View All →</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $txs = [
                            ['Mining Reward', '+250.0 NVC', 'Today 14:32', 'green'],
                            ['Convert → USDT', '-500 NVC', 'Today 11:00', 'green'],
                            ['Mining Reward', '+250.0 NVC', 'Today 08:00', 'green'],
                            ['USD Withdrawal', '-$42.10', 'Yesterday', 'green'],
                            ['Mining Reward', '+250.0 NVC', 'Yesterday', 'green'],
                            ['Referral Bonus', '+100.0 NVC', '2 days ago', 'gold'],
                        ];
                        @endphp
                        @foreach($txs as $tx)
                        <tr>
                            <td style="color:var(--text-muted);">{{ $tx[0] }}</td>
                            <td style="color:{{ str_starts_with($tx[1], '+') ? 'var(--green)' : 'var(--red)' }};">{{ $tx[1] }}</td>
                            <td style="color:var(--text-dim);">{{ $tx[2] }}</td>
                            <td><span class="badge badge-{{ $tx[3] }}" style="padding:0.15rem 0.5rem;font-size:0.62rem;">Done</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Notifications + Profile -->
            <div style="display:flex;flex-direction:column;gap:1rem;">
                <!-- Profile Summary -->
                <div class="card animate-in delay-4">
                    <div class="section-title" style="margin-bottom:1rem;">Account Summary</div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        @php
                        $profile = [
                            ['Country', '🇧🇩 Bangladesh'],
                            ['Member Since', 'Jan 12, 2024'],
                            ['KYC Status', '✓ Verified'],
                            ['Mining Rank', '#2,847'],
                            ['Referrals', '12 users'],
                            ['2FA Status', '✓ Enabled'],
                        ];
                        @endphp
                        @foreach($profile as $p)
                        <div style="background:rgba(255,255,255,0.02);border:1px solid var(--border);border-radius:3px;padding:0.625rem 0.75rem;">
                            <div style="font-size:0.65rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--text-dim);margin-bottom:0.25rem;">{{ $p[0] }}</div>
                            <div style="font-size:0.82rem;font-weight:600;color:{{ $p[0] === 'KYC Status' || $p[0] === '2FA Status' ? 'var(--green)' : ($p[0] === 'Mining Rank' ? 'var(--gold)' : 'var(--text-primary)') }};">{{ $p[1] }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="card animate-in delay-5">
                    <div class="section-title" style="margin-bottom:1rem;">Activity Feed</div>
                    @php
                    $activities = [
                        ['green', 'Mining session completed', '+250 NVC earned', '2 min ago'],
                        ['gold', 'Binance conversion success', '$21.05 USDT received', '3h ago'],
                        ['blue', 'Referral joined network', 'Bonus: +50 NVC', '1d ago'],
                        ['green', 'KYC verification passed', 'Full mining unlocked', '5d ago'],
                    ];
                    @endphp
                    @foreach($activities as $a)
                    <div class="notification-item">
                        <div class="activity-dot" style="background:var(--{{ $a[0] }});margin-top:6px;"></div>
                        <div style="flex:1;">
                            <div style="font-size:0.8rem;font-weight:600;color:var(--text-primary);">{{ $a[1] }}</div>
                            <div style="font-size:0.72rem;color:var(--text-muted);">{{ $a[2] }}</div>
                        </div>
                        <div style="font-size:0.68rem;color:var(--text-dim);white-space:nowrap;">{{ $a[3] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
    // Animate stat numbers
    document.querySelectorAll('.stat-value').forEach(el => {
        const text = el.textContent.trim();
        const num = parseFloat(text.replace(/[^0-9.]/g, ''));
        if (!isNaN(num) && num > 10) {
            let start = 0;
            const duration = 1200;
            const step = num / (duration / 16);
            const prefix = text.match(/^[^0-9]*/)[0];
            const suffix = text.match(/[^0-9.]*$/)[0];
            const decimals = (text.split('.')[1] || '').length;
            const timer = setInterval(() => {
                start = Math.min(start + step, num);
                el.textContent = prefix + start.toFixed(decimals) + suffix;
                if (start >= num) clearInterval(timer);
            }, 16);
        }
    });
</script>
@endsection