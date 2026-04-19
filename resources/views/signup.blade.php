@extends('layout')

@section('title', 'Create Account — NovaCoin')

@section('nav-actions')
    <span style="font-size:0.8rem;color:var(--text-muted);">Already mining?</span>
    <a href="/login" class="btn-ghost">Sign In</a>
@endsection

@section('extra-styles')
<style>
    .signup-wrap {
        display: grid;
        grid-template-columns: 1fr 480px 1fr;
        min-height: calc(100vh - 96px);
        align-items: start;
    }

    .signup-left {
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
        gap: 2rem;
    }

    .signup-form-wrap {
        padding: 2rem 0 4rem;
    }

    .signup-right {
        padding: 3rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .step-indicator {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 2rem;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.35rem;
        flex: 1;
        position: relative;
    }

    .step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 14px;
        left: 50%;
        width: 100%;
        height: 1px;
        background: var(--border);
    }

    .step.active:not(:last-child)::after,
    .step.done:not(:last-child)::after {
        background: var(--gold);
    }

    .step-dot {
        width: 28px; height: 28px;
        border-radius: 50%;
        border: 1px solid var(--border);
        background: var(--bg-card);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Orbitron', monospace;
        font-size: 0.65rem;
        font-weight: 700;
        color: var(--text-muted);
        position: relative;
        z-index: 1;
        transition: all 0.3s;
    }

    .step.active .step-dot {
        border-color: var(--gold);
        background: var(--gold);
        color: #000;
        box-shadow: 0 0 16px var(--gold-glow);
    }

    .step.done .step-dot {
        border-color: var(--green);
        background: var(--green);
        color: #000;
    }

    .step-name {
        font-size: 0.62rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-dim);
    }

    .step.active .step-name { color: var(--gold); }

    /* Form sections */
    .form-section {
        display: none;
    }
    .form-section.active { display: block; }

    .form-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .form-sub {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 1.75rem;
        line-height: 1.6;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* NID Upload Box */
    .upload-box {
        border: 1px dashed var(--border-bright);
        border-radius: 4px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: rgba(240,185,11,0.02);
        position: relative;
    }

    .upload-box:hover {
        border-color: var(--gold);
        background: rgba(240,185,11,0.05);
    }

    .upload-box input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-icon {
        width: 48px; height: 48px;
        margin: 0 auto 0.75rem;
        background: var(--gold-glow);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold);
    }

    /* Exchange logos */
    .exchange-badge {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 4px;
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .exchange-logo {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Orbitron', monospace;
        font-size: 0.6rem;
        font-weight: 900;
    }

    .binance-logo { background: #F0B90B; color: #000; }
    .coinbase-logo { background: #0052FF; color: #fff; }
    .kraken-logo { background: #5741D9; color: #fff; }

    /* Password strength */
    .pwd-strength {
        display: flex;
        gap: 4px;
        margin-top: 0.5rem;
    }

    .pwd-bar {
        flex: 1;
        height: 3px;
        background: var(--bg-card2);
        border-radius: 2px;
        transition: background 0.3s;
    }

    .pwd-bar.active { background: var(--gold); }
    .pwd-bar.strong { background: var(--green); }

    /* Country flag placeholder */
    .country-flag {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.1rem;
    }

    .field-wrap { position: relative; }

    /* Terms */
    .checkbox-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        cursor: pointer;
    }

    .checkbox-row input[type="checkbox"] {
        width: 16px; height: 16px;
        accent-color: var(--gold);
        margin-top: 2px;
        flex-shrink: 0;
    }

    .checkbox-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .checkbox-label a { color: var(--gold); text-decoration: none; }

    /* Security notice */
    .security-card {
        background: rgba(16,185,129,0.05);
        border: 1px solid rgba(16,185,129,0.2);
        border-radius: 4px;
        padding: 1rem;
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }

    .security-card svg { color: var(--green); flex-shrink: 0; margin-top: 2px; }

    .binance-hero {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--border);
        background: #1a1a1a;
        position: relative;
    }

    .binance-hero img {
        width: 100%;
        object-fit: cover;
    }

    .binance-promo {
        background: linear-gradient(135deg, #1a1200, #0d0900);
        border: 1px solid var(--border);
        border-radius: 4px;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
    }

    .binance-promo::before {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 100px; height: 100px;
        background: var(--gold-glow);
        border-radius: 50%;
        filter: blur(30px);
    }
</style>
@endsection

@section('content')
<div class="signup-wrap">
    <!-- LEFT PANEL -->
    <div class="signup-left animate-in delay-1">
        <div style="max-width:280px;">
            <div style="font-family:'Orbitron',monospace;font-size:0.7rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gold);margin-bottom:1rem;">✦ Trusted Exchange Partners</div>

            <div class="exchange-badge" style="margin-bottom:0.75rem;">
                <div class="exchange-logo binance-logo">BNB</div>
                <div>
                    <div style="font-weight:600;color:var(--text-primary);font-size:0.85rem;">Binance</div>
                    <div style="font-size:0.75rem;">Convert NVC → BTC/USDT</div>
                </div>
                <div style="margin-left:auto;" class="badge badge-green">Live</div>
            </div>

            <div class="exchange-badge" style="margin-bottom:0.75rem;">
                <div class="exchange-logo coinbase-logo">CB</div>
                <div>
                    <div style="font-weight:600;color:var(--text-primary);font-size:0.85rem;">Coinbase</div>
                    <div style="font-size:0.75rem;">Direct USD withdrawal</div>
                </div>
                <div style="margin-left:auto;" class="badge badge-green">Live</div>
            </div>

            <div class="exchange-badge">
                <div class="exchange-logo kraken-logo">KRK</div>
                <div>
                    <div style="font-weight:600;color:var(--text-primary);font-size:0.85rem;">Kraken</div>
                    <div style="font-size:0.75rem;">Advanced trading pairs</div>
                </div>
                <div style="margin-left:auto;" class="badge badge-gold">Soon</div>
            </div>

            <div class="divider"></div>

            <div class="binance-promo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Binance_Logo.svg/200px-Binance_Logo.svg.png"
                     alt="Binance" style="height:20px;margin-bottom:0.75rem;filter:brightness(1);">
                <div style="font-family:'Orbitron',monospace;font-size:0.85rem;font-weight:700;color:var(--gold);margin-bottom:0.35rem;">
                    0% Conversion Fee
                </div>
                <div style="font-size:0.78rem;color:var(--text-muted);line-height:1.6;">
                    First 30 days of NVC to USDT conversions are completely free through Binance integration.
                </div>
            </div>

            <div class="divider"></div>

            <div class="security-card">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <div>
                    <div style="font-size:0.78rem;font-weight:600;color:var(--green);margin-bottom:0.25rem;">Bank-Grade Security</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);line-height:1.5;">256-bit SSL encryption. Your NID data is processed via secure KYC partner and never stored in plaintext.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN FORM -->
    <div class="signup-form-wrap animate-in delay-2">
        <div style="text-align:center;margin-bottom:2rem;">
            <div style="font-family:'Orbitron',monospace;font-size:0.7rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--text-dim);margin-bottom:0.5rem;">Join the Network</div>
            <h1 style="font-family:'Orbitron',monospace;font-size:1.8rem;font-weight:900;color:var(--text-primary);">
                Create Your<br><span style="color:var(--gold);">Mining Account</span>
            </h1>
        </div>

        <!-- STEP INDICATOR -->
        <div class="step-indicator">
            <div class="step done" id="step-ind-1">
                <div class="step-dot">✓</div>
                <div class="step-name">Location</div>
            </div>
            <div class="step active" id="step-ind-2">
                <div class="step-dot">2</div>
                <div class="step-name">Identity</div>
            </div>
            <div class="step" id="step-ind-3">
                <div class="step-dot">3</div>
                <div class="step-name">Account</div>
            </div>
            <div class="step" id="step-ind-4">
                <div class="step-dot">4</div>
                <div class="step-name">Security</div>
            </div>
        </div>

        <div class="card">
            <!-- STEP 1: COUNTRY -->
            <div class="form-section" id="section-1">
                <div class="form-title">Select Your Country</div>
                <div class="form-sub">NovaCoin is available in 190+ countries. Regulatory compliance varies by region.</div>

                <div class="field-group">
                    <label class="field-label">Country of Residence</label>
                    <div class="field-wrap">
                        <select class="field-input" id="country-select" onchange="updateFlag(this.value)">
                            <option value="">— Select your country —</option>
                            <option value="BD">🇧🇩 Bangladesh</option>
                            <option value="US">🇺🇸 United States</option>
                            <option value="GB">🇬🇧 United Kingdom</option>
                            <option value="CA">🇨🇦 Canada</option>
                            <option value="AU">🇦🇺 Australia</option>
                            <option value="SG">🇸🇬 Singapore</option>
                            <option value="IN">🇮🇳 India</option>
                            <option value="AE">🇦🇪 UAE</option>
                            <option value="DE">🇩🇪 Germany</option>
                            <option value="FR">🇫🇷 France</option>
                            <option value="JP">🇯🇵 Japan</option>
                            <option value="KR">🇰🇷 South Korea</option>
                            <option value="BR">🇧🇷 Brazil</option>
                            <option value="NG">🇳🇬 Nigeria</option>
                            <option value="ZA">🇿🇦 South Africa</option>
                            <option value="PK">🇵🇰 Pakistan</option>
                            <option value="ID">🇮🇩 Indonesia</option>
                            <option value="PH">🇵🇭 Philippines</option>
                            <option value="MY">🇲🇾 Malaysia</option>
                            <option value="TH">🇹🇭 Thailand</option>
                        </select>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">State / Province</label>
                    <input type="text" class="field-input" placeholder="Enter state or province">
                </div>

                <div class="field-group">
                    <label class="field-label">Currency Preference</label>
                    <select class="field-input">
                        <option>USD — US Dollar</option>
                        <option>EUR — Euro</option>
                        <option>GBP — British Pound</option>
                        <option>BDT — Bangladeshi Taka</option>
                        <option>INR — Indian Rupee</option>
                        <option>AED — UAE Dirham</option>
                        <option>SGD — Singapore Dollar</option>
                    </select>
                </div>

                <div style="padding:0.875rem;background:rgba(240,185,11,0.05);border:1px solid var(--border);border-radius:4px;font-size:0.78rem;color:var(--text-muted);line-height:1.6;margin-bottom:1.5rem;">
                    ⚠️ Cryptocurrency mining and trading may be subject to local regulations. Please ensure compliance with your country's laws.
                </div>

                <button class="btn-primary" style="width:100%;justify-content:center;padding:0.875rem;" onclick="nextStep(2)">
                    Continue to Identity Verification →
                </button>
            </div>

            <!-- STEP 2: NID VERIFICATION -->
            <div class="form-section active" id="section-2">
                <div class="form-title">Identity Verification</div>
                <div class="form-sub">KYC verification is required to ensure secure and compliant mining operations.</div>

                <div class="grid-2" style="margin-bottom:1.25rem;">
                    <div class="field-group" style="margin-bottom:0;">
                        <label class="field-label">First Name</label>
                        <input type="text" class="field-input" placeholder="Given name">
                    </div>
                    <div class="field-group" style="margin-bottom:0;">
                        <label class="field-label">Last Name</label>
                        <input type="text" class="field-input" placeholder="Family name">
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">Date of Birth</label>
                    <input type="date" class="field-input">
                </div>

                <div class="field-group">
                    <label class="field-label">ID Document Type</label>
                    <select class="field-input">
                        <option>National ID Card (NID)</option>
                        <option>Passport</option>
                        <option>Driver's License</option>
                        <option>Voter ID</option>
                        <option>Birth Certificate + Secondary ID</option>
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-label">NID / Document Number</label>
                    <input type="text" class="field-input" placeholder="Enter your ID number" style="letter-spacing:0.1em;">
                </div>

                <div class="grid-2" style="margin-bottom:1.25rem;">
                    <div>
                        <div class="field-label" style="margin-bottom:0.5rem;">Front of ID</div>
                        <div class="upload-box" style="padding:1.5rem;">
                            <input type="file" accept="image/*,.pdf">
                            <div class="upload-icon">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/>
                                </svg>
                            </div>
                            <div style="font-size:0.78rem;color:var(--text-muted);">Upload front</div>
                            <div style="font-size:0.68rem;color:var(--text-dim);margin-top:0.25rem;">JPG, PNG, PDF</div>
                        </div>
                    </div>
                    <div>
                        <div class="field-label" style="margin-bottom:0.5rem;">Back of ID</div>
                        <div class="upload-box" style="padding:1.5rem;">
                            <input type="file" accept="image/*,.pdf">
                            <div class="upload-icon">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"/>
                                </svg>
                            </div>
                            <div style="font-size:0.78rem;color:var(--text-muted);">Upload back</div>
                            <div style="font-size:0.68rem;color:var(--text-dim);margin-top:0.25rem;">JPG, PNG, PDF</div>
                        </div>
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-label" style="margin-bottom:0.5rem;">Selfie with ID (Live Photo)</div>
                    <div class="upload-box">
                        <input type="file" accept="image/*" capture="user">
                        <div class="upload-icon" style="width:56px;height:56px;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                        </div>
                        <div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);margin-bottom:0.25rem;">Take or Upload Live Selfie</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">Hold your ID next to your face. Must be clearly visible.</div>
                    </div>
                </div>

                <div style="display:flex;gap:0.75rem;">
                    <button class="btn-ghost" onclick="nextStep(1)" style="flex:1;justify-content:center;padding:0.875rem;">← Back</button>
                    <button class="btn-primary" style="flex:2;justify-content:center;padding:0.875rem;" onclick="nextStep(3)">Verify Identity →</button>
                </div>
            </div>

            <!-- STEP 3: ACCOUNT DETAILS -->
            <div class="form-section" id="section-3">
                <div class="form-title">Account Details</div>
                <div class="form-sub">Set up your login credentials and contact information.</div>

                <div class="field-group">
                    <label class="field-label">Display Name / Username</label>
                    <input type="text" class="field-input" placeholder="miner_satoshi42">
                </div>

                <div class="field-group">
                    <label class="field-label">Email Address</label>
                    <input type="email" class="field-input" placeholder="you@example.com">
                </div>

                <div class="field-group">
                    <label class="field-label">Phone Number</label>
                    <div style="display:flex;gap:0.5rem;">
                        <select class="field-input" style="width:110px;flex-shrink:0;">
                            <option>+880 🇧🇩</option>
                            <option>+1 🇺🇸</option>
                            <option>+44 🇬🇧</option>
                            <option>+91 🇮🇳</option>
                            <option>+65 🇸🇬</option>
                            <option>+971 🇦🇪</option>
                        </select>
                        <input type="tel" class="field-input" placeholder="01XXXXXXXXX">
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">Referral Code (Optional)</label>
                    <input type="text" class="field-input" placeholder="Enter referral code for bonus tokens">
                </div>

                <div style="display:flex;gap:0.75rem;">
                    <button class="btn-ghost" onclick="nextStep(2)" style="flex:1;justify-content:center;padding:0.875rem;">← Back</button>
                    <button class="btn-primary" style="flex:2;justify-content:center;padding:0.875rem;" onclick="nextStep(4)">Continue →</button>
                </div>
            </div>

            <!-- STEP 4: SECURITY -->
            <div class="form-section" id="section-4">
                <div class="form-title">Secure Your Account</div>
                <div class="form-sub">Create a strong password and enable two-factor authentication.</div>

                <div class="field-group">
                    <label class="field-label">Password</label>
                    <input type="password" class="field-input" placeholder="Create a strong password" id="pwd-input" oninput="checkPwd(this.value)">
                    <div class="pwd-strength">
                        <div class="pwd-bar" id="pbar-1"></div>
                        <div class="pwd-bar" id="pbar-2"></div>
                        <div class="pwd-bar" id="pbar-3"></div>
                        <div class="pwd-bar" id="pbar-4"></div>
                    </div>
                    <div style="font-size:0.7rem;color:var(--text-muted);margin-top:0.35rem;" id="pwd-hint">Min 8 chars, uppercase, number, symbol</div>
                </div>

                <div class="field-group">
                    <label class="field-label">Confirm Password</label>
                    <input type="password" class="field-input" placeholder="Repeat password">
                </div>

                <div class="field-group">
                    <label class="field-label">Two-Factor Authentication (2FA)</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                        <div class="exchange-badge" style="cursor:pointer;border-color:var(--gold);">
                            <svg width="20" height="20" fill="none" stroke="var(--gold)" stroke-width="2" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12" y2="18"/></svg>
                            <div>
                                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">SMS Auth</div>
                                <div>Via mobile number</div>
                            </div>
                        </div>
                        <div class="exchange-badge" style="cursor:pointer;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                            <div>
                                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Google Auth</div>
                                <div>Authenticator app</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field-group">
                    <label class="checkbox-row">
                        <input type="checkbox">
                        <span class="checkbox-label">I agree to the <a href="#">Terms of Service</a>, <a href="#">Privacy Policy</a>, and confirm I am 18+ years of age.</span>
                    </label>
                </div>

                <div class="field-group">
                    <label class="checkbox-row">
                        <input type="checkbox">
                        <span class="checkbox-label">I understand that cryptocurrency mining involves risk and NovaCoin values are subject to market volatility.</span>
                    </label>
                </div>

                <button class="btn-primary" style="width:100%;justify-content:center;padding:1rem;font-size:0.85rem;" onclick="submitSignup()">
                    ⬡ Launch My Mining Account
                </button>

                <div style="text-align:center;margin-top:1rem;font-size:0.78rem;color:var(--text-muted);">
                    Already have an account? <a href="/login" style="color:var(--gold);text-decoration:none;">Sign in here</a>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="signup-right animate-in delay-3">
        <div style="font-family:'Orbitron',monospace;font-size:0.7rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--gold);margin-bottom:0.5rem;">✦ Mining Stats Today</div>

        <div class="stat-card" style="margin-bottom:0.75rem;">
            <div class="stat-label">Active Miners</div>
            <div class="stat-value" style="font-size:1.4rem;">284,719</div>
            <div class="stat-sub">↑ 1,240 joined today</div>
        </div>

        <div class="stat-card" style="margin-bottom:0.75rem;">
            <div class="stat-label">NVC Mined Today</div>
            <div class="stat-value" style="font-size:1.4rem;">4.2M</div>
            <div class="stat-sub">≈ $354,000 USD</div>
        </div>

        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:4px;overflow:hidden;">
            <div style="padding:0.875rem;border-bottom:1px solid var(--border);">
                <div style="font-size:0.72rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--text-muted);">New Members</div>
            </div>
            @php
            $members = [
                ['Rafi_H', 'BD', '2 min ago'],
                ['crypto_sarah', 'US', '5 min ago'],
                ['miner_leo', 'SG', '8 min ago'],
                ['nakamoto2', 'JP', '12 min ago'],
                ['blockchain_k', 'IN', '15 min ago'],
            ];
            @endphp
            @foreach($members as $m)
            <div style="display:flex;align-items:center;gap:0.75rem;padding:0.625rem 0.875rem;border-bottom:1px solid rgba(255,255,255,0.03);">
                <div style="width:28px;height:28px;background:var(--gold-glow);border:1px solid var(--border-bright);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-size:0.6rem;font-weight:700;color:var(--gold);">
                    {{ strtoupper(substr($m[0], 0, 1)) }}
                </div>
                <div style="flex:1;">
                    <div style="font-size:0.78rem;font-weight:600;color:var(--text-primary);">{{ $m[0] }}</div>
                    <div style="font-size:0.68rem;color:var(--text-muted);">{{ $m[1] }}</div>
                </div>
                <div style="font-size:0.68rem;color:var(--text-dim);">{{ $m[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentStep = 2;

    function nextStep(step) {
        document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
        document.getElementById('section-' + step).classList.add('active');

        document.querySelectorAll('.step').forEach((s, i) => {
            s.classList.remove('active', 'done');
            const n = i + 1;
            if (n < step) {
                s.classList.add('done');
                s.querySelector('.step-dot').textContent = '✓';
            } else if (n === step) {
                s.classList.add('active');
                s.querySelector('.step-dot').textContent = n;
            } else {
                s.querySelector('.step-dot').textContent = n;
            }
        });
        currentStep = step;
    }

    function checkPwd(val) {
        const bars = [1,2,3,4].map(i => document.getElementById('pbar-' + i));
        bars.forEach(b => { b.className = 'pwd-bar'; });
        let strength = 0;
        if (val.length >= 8) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;
        for (let i = 0; i < strength; i++) {
            bars[i].classList.add(strength >= 4 ? 'strong' : 'active');
        }
        const hints = ['Too short', 'Weak', 'Fair', 'Good', 'Strong ✓'];
        document.getElementById('pwd-hint').textContent = hints[strength];
    }

    function submitSignup() {
        const btn = event.target;
        btn.textContent = '⟳ Creating account...';
        btn.style.opacity = '0.7';
        setTimeout(() => { window.location.href = '/dashboard'; }, 1500);
    }
</script>
@endsection