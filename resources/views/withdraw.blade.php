@extends('layout')

@section('title', 'Withdraw Funds')

@push('styles')
<style>
    /* ============================================================
       WITHDRAW PAGE — Crypto Mining Platform
       Dark theme, Binance-inspired gold accents
    ============================================================ */

    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&display=swap');

    :root {
        --bg-base:        #0b0e11;
        --bg-card:        #161a1e;
        --bg-card-inner:  #1e2329;
        --gold:           #f0b90b;
        --gold-light:     #f8d06b;
        --gold-dim:       rgba(240,185,11,.12);
        --red:            #f6465d;
        --green:          #0ecb81;
        --text-primary:   #eaecef;
        --text-secondary: #848e9c;
        --border:         #2b3139;
        --radius:         12px;
        --radius-sm:      8px;
        --font-display:   'Syne', sans-serif;
        --font-mono:      'DM Mono', monospace;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg-base);
        color: var(--text-primary);
        font-family: var(--font-display);
        min-height: 100vh;
    }

    /* ── Page wrapper ── */
    .withdraw-page {
        max-width: 1100px;
        margin: 0 auto;
        padding: 32px 20px 60px;
    }

    /* ── Breadcrumb ── */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-secondary);
        margin-bottom: 28px;
    }
    .breadcrumb a { color: var(--text-secondary); text-decoration: none; transition: color .2s; }
    .breadcrumb a:hover { color: var(--gold); }
    .breadcrumb .sep { color: var(--border); }
    .breadcrumb .current { color: var(--text-primary); }

    /* ── Page header ── */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 36px;
    }
    .page-header h1 {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -.4px;
        line-height: 1;
    }
    .page-header h1 span { color: var(--gold); }

    .balance-pill {
        background: var(--gold-dim);
        border: 1px solid rgba(240,185,11,.25);
        border-radius: 99px;
        padding: 8px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--text-secondary);
    }
    .balance-pill .val {
        font-family: var(--font-mono);
        font-size: 15px;
        color: var(--gold-light);
        font-weight: 500;
    }

    /* ── Main grid ── */
    .wd-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 800px) { .wd-grid { grid-template-columns: 1fr; } }

    /* ── Card base ── */
    .card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }
    .card-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-header .icon {
        width: 36px; height: 36px;
        background: var(--gold-dim);
        border-radius: var(--radius-sm);
        display: grid; place-items: center;
        color: var(--gold);
        font-size: 16px;
        flex-shrink: 0;
    }
    .card-header h2 { font-size: 15px; font-weight: 700; }
    .card-body { padding: 24px; }

    /* ── Method tabs ── */
    .method-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }
    .method-tab {
        flex: 1; min-width: 120px;
        background: var(--bg-card-inner);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 14px 12px;
        cursor: pointer;
        text-align: center;
        transition: all .2s;
        position: relative;
        overflow: hidden;
    }
    .method-tab:hover { border-color: rgba(240,185,11,.4); }
    .method-tab.active {
        border-color: var(--gold);
        background: var(--gold-dim);
    }
    .method-tab.active::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 2px; background: var(--gold);
    }
    .method-tab .mt-logo {
        height: 22px; width: auto;
        display: block; margin: 0 auto 8px;
        object-fit: contain;
        filter: brightness(.7);
        transition: filter .2s;
    }
    .method-tab.active .mt-logo,
    .method-tab:hover .mt-logo { filter: brightness(1); }
    .method-tab .mt-name {
        font-size: 11px; font-weight: 600;
        color: var(--text-secondary);
        letter-spacing: .4px; text-transform: uppercase;
    }
    .method-tab.active .mt-name { color: var(--gold-light); }

    /* ── Form fields ── */
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; font-weight: 600;
        color: var(--text-secondary);
        letter-spacing: .5px; text-transform: uppercase;
        margin-bottom: 8px;
    }
    .form-label .required { color: var(--red); }
    .form-label .hint {
        margin-left: auto;
        font-size: 11px; font-weight: 400;
        text-transform: none; letter-spacing: 0;
        color: var(--text-secondary);
    }

    .input-wrap { position: relative; }
    .input-wrap .prefix, .input-wrap .suffix {
        position: absolute; top: 50%; transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 13px; pointer-events: none;
        display: flex; align-items: center; gap: 6px;
    }
    .input-wrap .prefix { left: 14px; }
    .input-wrap .suffix { right: 14px; }
    .input-wrap .prefix + input { padding-left: 44px; }
    .input-wrap input[type="text"],
    .input-wrap input[type="number"],
    select, textarea {
        width: 100%;
        background: var(--bg-card-inner);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        color: var(--text-primary);
        font-family: var(--font-display);
        font-size: 14px;
        padding: 12px 14px;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        appearance: none;
    }
    .input-wrap input[type="number"] { font-family: var(--font-mono); }
    .input-wrap input:focus,
    select:focus, textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(240,185,11,.1);
    }
    .input-wrap input.has-suffix { padding-right: 90px; }

    .max-btn {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: var(--gold-dim);
        border: 1px solid rgba(240,185,11,.3);
        color: var(--gold);
        font-family: var(--font-display);
        font-size: 11px; font-weight: 700;
        letter-spacing: .5px;
        padding: 4px 10px; border-radius: 4px;
        cursor: pointer; transition: all .2s;
    }
    .max-btn:hover { background: var(--gold); color: #000; }

    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23848e9c' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
    }
    select option { background: var(--bg-card-inner); }

    .helper-text {
        font-size: 11px; color: var(--text-secondary);
        margin-top: 6px; line-height: 1.5;
    }

    /* ── Amount slider ── */
    .amount-row {
        display: flex; gap: 8px; margin-top: 10px;
    }
    .pct-btn {
        flex: 1;
        background: var(--bg-card-inner);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        color: var(--text-secondary);
        font-family: var(--font-display);
        font-size: 12px; font-weight: 600;
        padding: 8px 4px; text-align: center;
        cursor: pointer; transition: all .2s;
    }
    .pct-btn:hover { border-color: var(--gold); color: var(--gold); }

    /* ── Network fee bar ── */
    .fee-bar {
        background: var(--bg-card-inner);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        margin-bottom: 20px;
    }
    .fee-row {
        display: flex; justify-content: space-between;
        align-items: center; font-size: 13px;
    }
    .fee-row + .fee-row { margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--border); }
    .fee-row .label { color: var(--text-secondary); }
    .fee-row .val { font-family: var(--font-mono); color: var(--text-primary); }
    .fee-row .val.receive { color: var(--green); font-weight: 600; }

    /* ── Submit button ── */
    .btn-withdraw {
        width: 100%;
        background: linear-gradient(135deg, #f0b90b 0%, #f8d06b 100%);
        color: #000;
        font-family: var(--font-display);
        font-size: 15px; font-weight: 800;
        letter-spacing: .3px;
        border: none; border-radius: var(--radius-sm);
        padding: 15px;
        cursor: pointer;
        transition: opacity .2s, transform .15s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-withdraw:hover { opacity: .9; transform: translateY(-1px); }
    .btn-withdraw:active { transform: translateY(0); }
    .btn-withdraw svg { width: 18px; height: 18px; }

    .btn-secondary {
        width: 100%;
        background: transparent;
        border: 1.5px solid var(--border);
        color: var(--text-secondary);
        font-family: var(--font-display);
        font-size: 13px; font-weight: 600;
        border-radius: var(--radius-sm);
        padding: 12px;
        cursor: pointer; margin-top: 10px;
        transition: all .2s;
    }
    .btn-secondary:hover { border-color: var(--text-secondary); color: var(--text-primary); }

    /* ── Notice box ── */
    .notice {
        background: rgba(246,70,93,.07);
        border: 1px solid rgba(246,70,93,.25);
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        display: flex; gap: 12px;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    .notice svg { flex-shrink: 0; color: var(--red); margin-top: 1px; }
    .notice p { font-size: 12px; color: var(--text-secondary); line-height: 1.6; }
    .notice p strong { color: var(--text-primary); }

    /* ── Sidebar ── */
    .sidebar { display: flex; flex-direction: column; gap: 20px; }

    /* ── Steps ── */
    .steps { display: flex; flex-direction: column; gap: 0; }
    .step {
        display: flex; gap: 14px;
        padding: 16px 0;
        border-bottom: 1px solid var(--border);
    }
    .step:last-child { border-bottom: none; }
    .step-num {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: var(--gold-dim);
        border: 1.5px solid var(--gold);
        display: grid; place-items: center;
        font-size: 12px; font-weight: 700;
        color: var(--gold);
        flex-shrink: 0;
    }
    .step-content h4 { font-size: 13px; font-weight: 700; margin-bottom: 4px; }
    .step-content p { font-size: 12px; color: var(--text-secondary); line-height: 1.55; }

    /* ── Limits table ── */
    .limits-table { width: 100%; border-collapse: collapse; }
    .limits-table tr { border-bottom: 1px solid var(--border); }
    .limits-table tr:last-child { border-bottom: none; }
    .limits-table td {
        padding: 11px 0; font-size: 13px;
        vertical-align: middle;
    }
    .limits-table td:last-child {
        text-align: right;
        font-family: var(--font-mono);
        color: var(--gold-light);
    }
    .limits-table td .label { color: var(--text-secondary); font-size: 12px; }

    /* ── History preview ── */
    .tx-list { display: flex; flex-direction: column; gap: 0; }
    .tx-item {
        display: flex; align-items: center; gap: 12px;
        padding: 13px 0;
        border-bottom: 1px solid var(--border);
        cursor: pointer; transition: background .15s;
    }
    .tx-item:last-child { border-bottom: none; }
    .tx-item:hover { margin: 0 -24px; padding-left: 24px; padding-right: 24px; background: rgba(255,255,255,.02); }
    .tx-icon {
        width: 34px; height: 34px; border-radius: 8px;
        display: grid; place-items: center; flex-shrink: 0; font-size: 14px;
    }
    .tx-icon.pending { background: rgba(240,185,11,.12); color: var(--gold); }
    .tx-icon.completed { background: rgba(14,203,129,.1); color: var(--green); }
    .tx-icon.failed { background: rgba(246,70,93,.1); color: var(--red); }
    .tx-info { flex: 1; min-width: 0; }
    .tx-info .tx-addr { font-size: 12px; font-family: var(--font-mono); color: var(--text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .tx-info .tx-date { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }
    .tx-amt { text-align: right; }
    .tx-amt .amount { font-family: var(--font-mono); font-size: 13px; font-weight: 500; }
    .tx-amt .status { font-size: 10px; font-weight: 600; letter-spacing: .4px; text-transform: uppercase; margin-top: 2px; }
    .tx-amt .status.pending { color: var(--gold); }
    .tx-amt .status.completed { color: var(--green); }
    .tx-amt .status.failed { color: var(--red); }

    .view-all {
        display: block; text-align: center;
        margin-top: 16px; font-size: 12px; font-weight: 600;
        color: var(--gold); text-decoration: none;
        letter-spacing: .3px;
    }
    .view-all:hover { text-decoration: underline; }

    /* ── Alert / flash messages ── */
    .alert {
        border-radius: var(--radius-sm); padding: 14px 16px;
        font-size: 13px; display: flex; gap: 10px;
        align-items: flex-start; margin-bottom: 24px;
    }
    .alert-success { background: rgba(14,203,129,.08); border: 1px solid rgba(14,203,129,.25); color: var(--green); }
    .alert-error   { background: rgba(246,70,93,.08);  border: 1px solid rgba(246,70,93,.25);  color: var(--red); }
    .alert p { flex: 1; line-height: 1.5; }

    /* ── 2FA badge ── */
    .twofa-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(14,203,129,.08);
        border: 1px solid rgba(14,203,129,.25);
        border-radius: 99px; padding: 4px 12px;
        font-size: 11px; font-weight: 600;
        color: var(--green); letter-spacing: .3px;
        margin-left: auto;
    }

    /* ── Responsive helpers ── */
    @media (max-width: 600px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .method-tabs { gap: 8px; }
        .amount-row { gap: 6px; }
    }
</style>
@endpush

@section('content')
<div class="withdraw-page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="/dashboard">Dashboard</a>
        <span class="sep">›</span>
        <a href="#">Wallet</a>
        <span class="sep">›</span>
        <span class="current">Withdraw</span>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px">
                <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Page header --}}
    <div class="page-header">
        <h1>Withdraw <span>Funds</span></h1>
        <div class="balance-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                <line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
            Available Balance
            <span class="val">{{ number_format($user->balance ?? 0, 4) }} {{ $coinSymbol ?? 'CRX' }}</span>
        </div>
    </div>

    <div class="wd-grid">

        {{-- ═══════════════════════════════════
             LEFT — Withdraw Form
        ═══════════════════════════════════ --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                    </div>
                    <h2>Withdraw Crypto</h2>
                    <span class="twofa-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        2FA Protected
                    </span>
                </div>

                <div class="card-body">

                    {{-- Exchange Method Tabs --}}
                    <div class="method-tabs" id="methodTabs">
                        <div class="method-tab active" data-method="binance" onclick="selectMethod(this)">
                            <img src="https://cryptologos.cc/logos/binance-coin-bnb-logo.png"
                                 alt="Binance" class="mt-logo"
                                 onerror="this.style.display='none'">
                            <div class="mt-name">Binance</div>
                        </div>
                        <div class="method-tab" data-method="coinbase" onclick="selectMethod(this)">
                            <img src="https://cryptologos.cc/logos/coinbase-coin-logo.png"
                                 alt="Coinbase" class="mt-logo"
                                 onerror="this.style.display='none'">
                            <div class="mt-name">Coinbase</div>
                        </div>
                        <div class="method-tab" data-method="wallet" onclick="selectMethod(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.5" style="display:block;margin:0 auto 8px">
                                <rect x="1" y="6" width="22" height="14" rx="2"/>
                                <path d="M16 12h2" stroke-linecap="round"/>
                            </svg>
                            <div class="mt-name">Direct Wallet</div>
                        </div>
                        <div class="method-tab" data-method="bank" onclick="selectMethod(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.5" style="display:block;margin:0 auto 8px">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                            <div class="mt-name">Bank / USD</div>
                        </div>
                    </div>

                    {{-- Withdraw Form --}}
                    <form action="" method="POST" id="withdrawForm">
                        @csrf
                        <input type="hidden" name="method" id="selectedMethod" value="binance">

                        {{-- Coin selection --}}
                        <div class="form-group">
                            <label class="form-label">
                                Coin / Token
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrap">
                                <select name="coin" id="coinSelect" onchange="updateFeePreview()">
                                    <option value="CRX" {{ old('coin') == 'CRX' ? 'selected' : '' }}>
                                        {{ $coinName ?? 'CRX Token' }} ({{ $coinSymbol ?? 'CRX' }})
                                    </option>
                                    <option value="BTC" {{ old('coin') == 'BTC' ? 'selected' : '' }}>Bitcoin (BTC)</option>
                                    <option value="ETH" {{ old('coin') == 'ETH' ? 'selected' : '' }}>Ethereum (ETH)</option>
                                    <option value="USDT" {{ old('coin') == 'USDT' ? 'selected' : '' }}>Tether (USDT)</option>
                                    <option value="BNB" {{ old('coin') == 'BNB' ? 'selected' : '' }}>BNB (BNB)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Network --}}
                        <div class="form-group" id="networkGroup">
                            <label class="form-label">
                                Network
                                <span class="required">*</span>
                                <span class="hint">Select the same network on your exchange</span>
                            </label>
                            <div class="input-wrap">
                                <select name="network" onchange="updateFeePreview()">
                                    <option value="BEP20">BNB Smart Chain (BEP20)</option>
                                    <option value="ERC20">Ethereum (ERC20)</option>
                                    <option value="TRC20">TRON (TRC20)</option>
                                    <option value="native">Native Chain</option>
                                </select>
                            </div>
                            <p class="helper-text">⚠️ Sending to the wrong network may result in permanent loss of funds.</p>
                        </div>

                        {{-- Recipient Address --}}
                        <div class="form-group" id="addressGroup">
                            <label class="form-label">
                                Recipient Address
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrap">
                                <input type="text" name="address"
                                       value="{{ old('address') }}"
                                       placeholder="Enter wallet address or Binance UID"
                                       required>
                            </div>
                            @error('address')
                                <p class="helper-text" style="color:var(--red)">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- UID field (Binance specific) --}}
                        <div class="form-group" id="uidGroup" style="display:none">
                            <label class="form-label">
                                Binance Pay UID / Email
                            </label>
                            <div class="input-wrap">
                                <input type="text" name="binance_uid"
                                       value="{{ old('binance_uid') }}"
                                       placeholder="Binance UID, Pay ID or registered email">
                            </div>
                        </div>

                        {{-- Amount --}}
                        <div class="form-group">
                            <label class="form-label">
                                Withdrawal Amount
                                <span class="required">*</span>
                                <span class="hint">
                                    Balance: <strong style="color:var(--gold-light)">
                                        {{ number_format($user->balance ?? 0, 4) }} {{ $coinSymbol ?? 'CRX' }}
                                    </strong>
                                </span>
                            </label>
                            <div class="input-wrap">
                                <span class="prefix">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="16"/>
                                        <line x1="8" y1="12" x2="16" y2="12"/>
                                    </svg>
                                </span>
                                <input type="number" name="amount" id="amountInput"
                                       value="{{ old('amount') }}"
                                       placeholder="0.0000"
                                       min="10" step="0.0001"
                                       class="has-suffix"
                                       onkeyup="updateFeePreview()"
                                       required>
                                <button type="button" class="max-btn"
                                        onclick="setMaxAmount()">MAX</button>
                            </div>
                            @error('amount')
                                <p class="helper-text" style="color:var(--red)">{{ $message }}</p>
                            @enderror

                            {{-- Percentage shortcuts --}}
                            <div class="amount-row">
                                @foreach([25, 50, 75, 100] as $pct)
                                    <button type="button" class="pct-btn"
                                            onclick="setPct({{ $pct }})">{{ $pct }}%</button>
                                @endforeach
                            </div>
                        </div>

                        {{-- 2FA Code --}}
                        <div class="form-group">
                            <label class="form-label">
                                2FA Verification Code
                                <span class="required">*</span>
                            </label>
                            <div class="input-wrap">
                                <input type="text" name="two_fa_code"
                                       placeholder="Enter 6-digit authenticator code"
                                       maxlength="6" inputmode="numeric"
                                       pattern="[0-9]{6}"
                                       style="font-family:var(--font-mono);letter-spacing:6px;font-size:18px;text-align:center"
                                       required>
                            </div>
                            @error('two_fa_code')
                                <p class="helper-text" style="color:var(--red)">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Fee Preview --}}
                        <div class="fee-bar">
                            <div class="fee-row">
                                <span class="label">Withdrawal Amount</span>
                                <span class="val" id="feeAmount">—</span>
                            </div>
                            <div class="fee-row">
                                <span class="label">Network Fee</span>
                                <span class="val" id="feeNetwork">—</span>
                            </div>
                            <div class="fee-row">
                                <span class="label">Platform Fee (0.5%)</span>
                                <span class="val" id="feePlatform">—</span>
                            </div>
                            <div class="fee-row">
                                <span class="label" style="font-weight:700;color:var(--text-primary)">You Will Receive</span>
                                <span class="val receive" id="feeReceive">—</span>
                            </div>
                        </div>

                        {{-- Safety notice --}}
                        <div class="notice">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <p>
                                <strong>Important:</strong> Withdrawals are processed within
                                <strong>10–30 minutes</strong> after confirmation.
                                Minimum withdrawal is <strong>10 {{ $coinSymbol ?? 'CRX' }}</strong>.
                                Ensure the address and network match exactly — transactions
                                cannot be reversed once submitted.
                            </p>
                        </div>

                        <button type="submit" class="btn-withdraw">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="15" x2="12" y2="3"/>
                            </svg>
                            Submit Withdrawal Request
                        </button>

                        <button type="button" class="btn-secondary"
                                onclick="window.location='/dashboard'">
                            Cancel &amp; Go Back
                        </button>

                    </form>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════
             RIGHT — Sidebar
        ═══════════════════════════════════ --}}
        <div class="sidebar">

            {{-- How it works --}}
            <div class="card">
                <div class="card-header">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <h2>How Withdrawals Work</h2>
                </div>
                <div class="card-body" style="padding-top:8px;padding-bottom:8px">
                    <div class="steps">
                        <div class="step">
                            <div class="step-num">1</div>
                            <div class="step-content">
                                <h4>Choose Method &amp; Coin</h4>
                                <p>Select your preferred exchange (Binance, Coinbase) or direct wallet, then pick the coin you want to withdraw.</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-num">2</div>
                            <div class="step-content">
                                <h4>Enter Address &amp; Amount</h4>
                                <p>Paste your wallet address and enter the amount. Double-check the network — wrong network = lost funds.</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-num">3</div>
                            <div class="step-content">
                                <h4>Confirm with 2FA</h4>
                                <p>Enter your 6-digit authenticator code to authorize the request securely.</p>
                            </div>
                        </div>
                        <div class="step">
                            <div class="step-num">4</div>
                            <div class="step-content">
                                <h4>Wait for Processing</h4>
                                <p>Your withdrawal is processed within 10–30 minutes. Track it in your transaction history.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Limits --}}
            <div class="card">
                <div class="card-header">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="8" y1="6" x2="21" y2="6"/>
                            <line x1="8" y1="12" x2="21" y2="12"/>
                            <line x1="8" y1="18" x2="21" y2="18"/>
                            <line x1="3" y1="6" x2="3.01" y2="6"/>
                            <line x1="3" y1="12" x2="3.01" y2="12"/>
                            <line x1="3" y1="18" x2="3.01" y2="18"/>
                        </svg>
                    </div>
                    <h2>Withdrawal Limits</h2>
                </div>
                <div class="card-body">
                    <table class="limits-table">
                        <tr>
                            <td><span class="label">Minimum</span></td>
                            <td>10 {{ $coinSymbol ?? 'CRX' }}</td>
                        </tr>
                        <tr>
                            <td><span class="label">Daily Limit</span></td>
                            <td>{{ number_format($limits['daily'] ?? 10000) }} {{ $coinSymbol ?? 'CRX' }}</td>
                        </tr>
                        <tr>
                            <td><span class="label">Monthly Limit</span></td>
                            <td>{{ number_format($limits['monthly'] ?? 100000) }} {{ $coinSymbol ?? 'CRX' }}</td>
                        </tr>
                        <tr>
                            <td><span class="label">Withdrawn Today</span></td>
                            <td style="color:var(--text-primary)">{{ number_format($stats['today'] ?? 0, 4) }}</td>
                        </tr>
                        <tr>
                            <td><span class="label">Network Fee</span></td>
                            <td>{{ $fees['network'] ?? '0.001' }} BNB</td>
                        </tr>
                        <tr>
                            <td><span class="label">Platform Fee</span></td>
                            <td>0.5%</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Recent withdrawals --}}
            <div class="card">
                <div class="card-header">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="12 8 12 12 14 14"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                    </div>
                    <h2>Recent Withdrawals</h2>
                </div>
                <div class="card-body">
                    <div class="tx-list">
                        @forelse($recentWithdrawals ?? [] as $tx)
                            <div class="tx-item">
                                <div class="tx-icon {{ $tx->status }}">
                                    @if($tx->status === 'completed')
                                        ✓
                                    @elseif($tx->status === 'pending')
                                        ⏳
                                    @else
                                        ✕
                                    @endif
                                </div>
                                <div class="tx-info">
                                    <div class="tx-addr">{{ Str::limit($tx->address, 20) }}</div>
                                    <div class="tx-date">{{ $tx->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="tx-amt">
                                    <div class="amount">{{ number_format($tx->amount, 4) }}</div>
                                    <div class="status {{ $tx->status }}">{{ ucfirst($tx->status) }}</div>
                                </div>
                            </div>
                        @empty
                            {{-- Placeholder rows when no real data is available --}}
                            <div class="tx-item">
                                <div class="tx-icon completed">✓</div>
                                <div class="tx-info">
                                    <div class="tx-addr">0x4a3b…f92c</div>
                                    <div class="tx-date">2 hours ago</div>
                                </div>
                                <div class="tx-amt">
                                    <div class="amount">250.0000</div>
                                    <div class="status completed">Completed</div>
                                </div>
                            </div>
                            <div class="tx-item">
                                <div class="tx-icon pending">⏳</div>
                                <div class="tx-info">
                                    <div class="tx-addr">0x9d1e…b44f</div>
                                    <div class="tx-date">5 hours ago</div>
                                </div>
                                <div class="tx-amt">
                                    <div class="amount">100.0000</div>
                                    <div class="status pending">Pending</div>
                                </div>
                            </div>
                            <div class="tx-item">
                                <div class="tx-icon failed">✕</div>
                                <div class="tx-info">
                                    <div class="tx-addr">0x7c2a…190d</div>
                                    <div class="tx-date">Yesterday</div>
                                </div>
                                <div class="tx-amt">
                                    <div class="amount">500.0000</div>
                                    <div class="status failed">Failed</div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <a href="" class="view-all">View Full History →</a>
                </div>
            </div>

        </div>{{-- /sidebar --}}
    </div>{{-- /wd-grid --}}
</div>{{-- /withdraw-page --}}
@endsection


@push('scripts')
<script>
    /* ── User balance (passed from controller) ── */
    const USER_BALANCE = {{ $user->balance ?? 0 }};
    const NETWORK_FEE  = 0.001;   // BNB fixed fee
    const PLATFORM_FEE = 0.005;   // 0.5%
    const COIN_SYMBOL  = "{{ $coinSymbol ?? 'CRX' }}";

    /* ── Method tab switcher ── */
    function selectMethod(el) {
        document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('selectedMethod').value = el.dataset.method;

        const uidGroup  = document.getElementById('uidGroup');
        uidGroup.style.display = el.dataset.method === 'binance' ? 'block' : 'none';
    }

    /* ── MAX button ── */
    function setMaxAmount() {
        const net = NETWORK_FEE;
        const max = Math.max(0, USER_BALANCE - net);
        document.getElementById('amountInput').value = max.toFixed(4);
        updateFeePreview();
    }

    /* ── Percentage shortcuts ── */
    function setPct(pct) {
        const amt = ((USER_BALANCE * pct) / 100).toFixed(4);
        document.getElementById('amountInput').value = amt;
        updateFeePreview();
    }

    /* ── Live fee preview ── */
    function updateFeePreview() {
        const raw = parseFloat(document.getElementById('amountInput').value) || 0;
        if (raw <= 0) {
            ['feeAmount','feeNetwork','feePlatform','feeReceive']
                .forEach(id => document.getElementById(id).textContent = '—');
            return;
        }
        const platform  = raw * PLATFORM_FEE;
        const network   = NETWORK_FEE;
        const receives  = Math.max(0, raw - platform - network);

        document.getElementById('feeAmount').textContent   = raw.toFixed(4)      + ' ' + COIN_SYMBOL;
        document.getElementById('feeNetwork').textContent  = network.toFixed(4)  + ' BNB';
        document.getElementById('feePlatform').textContent = platform.toFixed(4) + ' ' + COIN_SYMBOL;
        document.getElementById('feeReceive').textContent  = receives.toFixed(4) + ' ' + COIN_SYMBOL;
    }

    /* ── Form validation before submit ── */
    document.getElementById('withdrawForm').addEventListener('submit', function(e) {
        const amount = parseFloat(document.getElementById('amountInput').value);
        if (isNaN(amount) || amount < 10) {
            e.preventDefault();
            alert('Minimum withdrawal amount is 10 ' + COIN_SYMBOL + '.');
            return;
        }
        if (amount > USER_BALANCE) {
            e.preventDefault();
            alert('Insufficient balance.');
            return;
        }
    });
</script>
@endpush