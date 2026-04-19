@extends('layout')

@section('title', 'Sign In — NovaCoin')

@section('nav-actions')
    <span style="font-size:0.8rem;color:var(--text-muted);">New to NovaCoin?</span>
    <a href="/signup" class="btn-primary">Create Account</a>
@endsection

@section('extra-styles')
<style>
    .login-page {
        min-height: calc(100vh - 96px);
        display: grid;
        grid-template-columns: 1fr 440px 1fr;
        align-items: center;
    }

    .login-left {
        padding: 3rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        align-items: flex-end;
    }

    .login-center {
        padding: 2rem 0;
    }

    .login-right {
        padding: 3rem;
    }

    .login-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 2.5rem 2rem;
        position: relative;
    }

    .login-card::before {
        content: '';
        position: absolute;
        top: 0; left: 10%; right: 10%;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
    }

    .login-card::after {
        content: '';
        position: absolute;
        top: -60px; left: 50%;
        transform: translateX(-50%);
        width: 120px; height: 120px;
        background: var(--gold-glow);
        border-radius: 50%;
        filter: blur(40px);
        pointer-events: none;
    }

    .social-login {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.7rem;
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--border);
        border-radius: 3px;
        color: var(--text-muted);
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .social-btn:hover {
        border-color: var(--border-bright);
        color: var(--text-primary);
        background: rgba(255,255,255,0.05);
    }

    .or-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .or-divider::before, .or-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .or-divider span {
        font-size: 0.72rem;
        color: var(--text-dim);
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .forgot-link {
        font-size: 0.75rem;
        color: var(--gold);
        text-decoration: none;
        float: right;
        margin-top: -1rem;
        margin-bottom: 0.5rem;
    }

    .forgot-link:hover { text-decoration: underline; }

    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 4px;
    }

    .feature-icon {
        width: 40px; height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: var(--gold-glow);
        color: var(--gold);
    }

    .market-mini {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 4px;
        overflow: hidden;
    }

    .market-row {
        display: flex;
        align-items: center;
        padding: 0.7rem 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.03);
        gap: 0.75rem;
    }

    .coin-avatar {
        width: 30px; height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Orbitron', monospace;
        font-size: 0.6rem;
        font-weight: 700;
    }

    .sparkline {
        flex: 1;
        height: 30px;
    }
</style>
@endsection

@section('content')
<div class="login-page">

    <!-- LEFT: FEATURES -->
    <div class="login-left animate-in delay-1">
        <div style="max-width:300px;width:100%;">
            <div style="font-family:'Orbitron',monospace;font-size:0.7rem;letter-spacing:0.2em;color:var(--gold);margin-bottom:1.5rem;">✦ Why NovaCoin?</div>

            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:0.85rem;color:var(--text-primary);margin-bottom:0.2rem;">Lightning Mining</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);line-height:1.5;">Mine NVC tokens directly from your browser. No hardware required.</div>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:0.85rem;color:var(--text-primary);margin-bottom:0.2rem;">Instant USD Conversion</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);line-height:1.5;">Convert NVC to USD via Binance. Withdraw to your bank in 24h.</div>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:0.85rem;color:var(--text-primary);margin-bottom:0.2rem;">KYC Verified & Secure</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);line-height:1.5;">Every account is identity-verified. Your funds are always protected.</div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Mini market -->
            <div style="font-family:'Orbitron',monospace;font-size:0.65rem;letter-spacing:0.15em;color:var(--text-muted);margin-bottom:0.75rem;">LIVE PRICES</div>
            <div class="market-mini">
                @php
                $coins = [
                    ['NVC', '#F0B90B', '$0.0842', '+12.4%', true],
                    ['BTC', '#F7931A', '$62,450', '+1.2%', true],
                    ['ETH', '#627EEA', '$3,210', '-0.8%', false],
                    ['BNB', '#F0B90B', '$412.3', '+2.1%', true],
                ];
                @endphp
                @foreach($coins as $c)
                <div class="market-row">
                    <div class="coin-avatar" style="background:{{ $c[1] }}22;color:{{ $c[1] }};">{{ $c[0] }}</div>
                    <div style="flex:1;">
                        <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">{{ $c[0] }}</div>
                        <div style="font-family:'JetBrains Mono',monospace;font-size:0.75rem;color:var(--text-muted);">{{ $c[2] }}</div>
                    </div>
                    <div style="font-family:'JetBrains Mono',monospace;font-size:0.75rem;color:{{ $c[4] ? 'var(--green)' : 'var(--red)' }};">
                        {{ $c[3] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CENTER: LOGIN FORM -->
    <div class="login-center animate-in delay-2">
        <div style="text-align:center;margin-bottom:2rem;">
            <a href="/" style="font-family:'Orbitron',monospace;font-size:2rem;font-weight:900;color:var(--gold);text-decoration:none;">NOVA<span style="color:var(--text-dim);">COIN</span></a>
            <div style="font-size:0.85rem;color:var(--text-muted);margin-top:0.5rem;">Access your mining dashboard</div>
        </div>

        <div class="login-card">
            <div class="social-login">
                <a href="#" class="social-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </a>
                <a href="#" class="social-btn">
                    <div style="width:16px;height:16px;background:#F0B90B;border-radius:2px;display:flex;align-items:center;justify-content:center;font-size:0.55rem;font-weight:900;color:#000;">BNB</div>
                    Binance
                </a>
            </div>

            <div class="or-divider"><span>or sign in with email</span></div>

            <div class="field-group">
                <label class="field-label">Email Address</label>
                <input type="email" class="field-input" placeholder="you@example.com" autofocus>
            </div>

            <div class="field-group">
                <label class="field-label">Password</label>
                <input type="password" class="field-input" placeholder="••••••••••••">
                <a href="/forgot-password" class="forgot-link">Forgot password?</a>
            </div>

            <div style="clear:both;"></div>

            <div class="field-group">
                <label class="checkbox-row" style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                    <input type="checkbox" style="accent-color:var(--gold);">
                    <span style="font-size:0.8rem;color:var(--text-muted);">Remember me on this device</span>
                </label>
            </div>

            <button class="btn-primary" style="width:100%;justify-content:center;padding:0.9rem;font-size:0.8rem;" onclick="doLogin()">
                Sign In to Dashboard →
            </button>

            <div id="login-loading" style="display:none;text-align:center;padding:0.5rem;">
                <div style="font-family:'JetBrains Mono',monospace;font-size:0.78rem;color:var(--gold);">
                    ⟳ Authenticating...
                </div>
            </div>

            <div class="divider"></div>

            <div style="display:flex;gap:0.75rem;padding:0.875rem;background:rgba(240,185,11,0.03);border:1px solid var(--border);border-radius:4px;align-items:center;">
                <svg width="18" height="18" fill="none" stroke="var(--gold)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                <div style="font-size:0.75rem;color:var(--text-muted);">
                    Protected by 2FA • SSL encrypted • No cookies sold
                </div>
            </div>

            <div style="text-align:center;margin-top:1.25rem;font-size:0.8rem;color:var(--text-muted);">
                Don't have an account?
                <a href="/signup" style="color:var(--gold);text-decoration:none;font-weight:600;">Start Mining Free →</a>
            </div>
        </div>
    </div>

    <!-- RIGHT: STATS -->
    <div class="login-right animate-in delay-3">
        <div style="max-width:280px;">
            <div style="font-family:'Orbitron',monospace;font-size:0.7rem;letter-spacing:0.2em;color:var(--gold);margin-bottom:1.5rem;">✦ Network Overview</div>

            <div class="stat-card" style="margin-bottom:1rem;">
                <div class="stat-label">NVC Price</div>
                <div class="stat-value">$0.0842</div>
                <div class="stat-sub" style="color:var(--green);">▲ +12.4% past 24h</div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1rem;">
                <div class="stat-card">
                    <div class="stat-label">Total Supply</div>
                    <div class="stat-value" style="font-size:1.1rem;">21B</div>
                    <div class="stat-sub">NVC tokens</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Mined</div>
                    <div class="stat-value" style="font-size:1.1rem;">3.8B</div>
                    <div class="stat-sub">18% of supply</div>
                </div>
            </div>

            <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:4px;padding:1rem;margin-bottom:1rem;">
                <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.15em;text-transform:uppercase;color:var(--text-muted);margin-bottom:0.75rem;">Mining Progress</div>
                <div style="display:flex;justify-content:space-between;font-family:'JetBrains Mono',monospace;font-size:0.75rem;color:var(--text-muted);margin-bottom:0.5rem;">
                    <span>3.8B / 21B NVC</span>
                    <span style="color:var(--gold);">18%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width:18%;"></div>
                </div>
                <div style="font-size:0.72rem;color:var(--text-dim);margin-top:0.5rem;">Est. full mining: ~2031</div>
            </div>

            <!-- Binance integration badge -->
            <div style="background:linear-gradient(135deg,#1a1200,#0d0900);border:1px solid rgba(240,185,11,0.3);border-radius:4px;padding:1rem;display:flex;align-items:center;gap:1rem;">
                <div style="width:44px;height:44px;background:#F0B90B;border-radius:8px;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.55rem;font-weight:900;color:#000;flex-shrink:0;">BNB</div>
                <div>
                    <div style="font-size:0.78rem;font-weight:700;color:var(--gold);margin-bottom:0.2rem;">Binance Integrated</div>
                    <div style="font-size:0.72rem;color:var(--text-muted);line-height:1.5;">Direct NVC → USDT conversion. Listed on Binance Launchpad.</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function doLogin() {
        document.querySelector('.btn-primary').style.display = 'none';
        document.getElementById('login-loading').style.display = 'block';
        setTimeout(() => { window.location.href = '/dashboard'; }, 1200);
    }
</script>
@endsection