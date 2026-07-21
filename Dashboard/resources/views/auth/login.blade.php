<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — VetenCall</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:       #4318FF;
            --primary-light: #EEF2FF;
            --secondary:     #00B5D8;
            --bg:            #F4F7FE;
            --surface:       #ffffff;
            --border:        #E2E8F0;
            --text:          #1B2559;
            --muted:         #A3AED0;
            --green:         #05CD99;
            --green-bg:      #E6FBF5;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            color: var(--text);
        }

        /* ── Left panel — illustration / brand ── */
        .panel-left {
            flex: 1;
            background: var(--primary);
            background-image:
                radial-gradient(ellipse at 20% 20%, rgba(255,255,255,0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 80%, rgba(0,181,216,0.25) 0%, transparent 60%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 56px 64px;
            position: relative;
            overflow: hidden;
        }

        /* subtle grid overlay */
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 0;
        }

        .panel-left > * { position: relative; z-index: 1; }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-name {
            font-size: 1.15rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.4px;
        }

        .panel-headline {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 0;
        }
        .panel-headline h1 {
            font-size: clamp(2rem, 3vw, 3rem);
            font-weight: 900;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
        }
        .panel-headline p {
            font-size: 1rem;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            max-width: 360px;
        }

        .stat-row {
            display: flex;
            gap: 20px;
        }
        .stat-chip {
            flex: 1;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            padding: 20px;
        }
        .stat-chip-value {
            font-size: 1.8rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -1px;
        }
        .stat-chip-label {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.5);
            font-weight: 500;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── Right panel — form ── */
        .panel-right {
            position: relative;
            width: 460px;
            flex-shrink: 0;
            background: var(--surface);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 64px 56px;
            border-left: 1px solid var(--border);
        }

        /* ── Seam overlay — sits at the boundary exactly ── */
        .panel-right::before {
            content: '';
            position: absolute;
            top: 0; bottom: 0; left: 0;
            width: 64px;
            transform: translateX(-50%);
            z-index: 50;
            pointer-events: none;

            backdrop-filter: blur(14px) saturate(1.6);
            -webkit-backdrop-filter: blur(14px) saturate(1.6);

            background: linear-gradient(
                to right,
                rgba(255,255,255,0)    0%,
                rgba(255,255,255,0.12) 30%,
                rgba(255,255,255,0.22) 50%,
                rgba(255,255,255,0.12) 70%,
                rgba(255,255,255,0)    100%
            );
        }

        .form-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--green-bg);
            color: var(--green);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 100px;
            margin-bottom: 28px;
            width: fit-content;
        }
        .eyebrow-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--green);
            animation: blink 2s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.3} }

        .form-title {
            font-size: 2rem;
            font-weight: 900;
            color: var(--text);
            letter-spacing: -1px;
            margin-bottom: 8px;
        }
        .form-subtitle {
            font-size: 0.9rem;
            color: var(--muted);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        /* Field */
        .field { margin-bottom: 22px; }
        .field-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 8px;
            display: block;
        }
        .field-wrap { position: relative; }
        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            color: var(--muted);
            pointer-events: none;
            transition: color 0.2s;
        }
        .field-input {
            width: 100%;
            padding: 12px 14px 12px 44px;
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .field-input::placeholder { color: #C5CEE0; }
        .field-input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(67,24,255,0.08);
        }
        .field-wrap:focus-within .field-icon { color: var(--primary); }

        /* Divider row */
        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }
        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            cursor: pointer;
            user-select: none;
        }
        .remember input[type="checkbox"] {
            appearance: none;
            width: 16px; height: 16px;
            border: 1.5px solid var(--border);
            border-radius: 5px;
            background: #fff;
            cursor: pointer;
            position: relative;
            transition: all 0.15s;
            flex-shrink: 0;
        }
        .remember input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
        }
        .remember input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1px;
            width: 5px; height: 9px;
            border: 2px solid #fff;
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }
        .remember-label { font-size: 0.82rem; color: var(--muted); font-weight: 500; }
        .forgot-link {
            font-size: 0.82rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .forgot-link:hover { opacity: 0.7; }

        /* Submit */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--primary);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 20px rgba(67,24,255,0.3);
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }
        .btn-submit:hover {
            background: #3311db;
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(67,24,255,0.4);
        }
        .btn-submit:active { transform: translateY(0); }

        /* Alerts */
        .alert {
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 0.83rem;
            font-weight: 500;
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-error  { background: #FFF0F0; border: 1px solid #FECACA; color: #DC2626; }
        .alert-success { background: var(--green-bg); border: 1px solid #A7F3D0; color: #059669; }

        /* Footer */
        .form-footer {
            margin-top: 36px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            font-size: 0.78rem;
            color: var(--muted);
            text-align: center;
        }

        @media (max-width: 860px) {
            .panel-left { display: none; }
            .panel-right { width: 100%; border: none; }
        }
    </style>
</head>
<body>

    <!-- Left Panel -->
    <div class="panel-left">
        <div class="brand">
            <div class="brand-icon" style="background: #ffffff; border-radius: 14px; padding: 10px; width: 52px; height: 52px; box-shadow: 0 0 30px rgba(255,255,255,0.3); border: none;">
                <img src="{{ asset('images/VetenCall.png') }}" alt="VetenCall" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <span class="brand-name">VetenCall</span>
        </div>

        <div class="panel-headline">
            <h1>Your WhatsApp<br>Command Center.</h1>
            <p>Manage bulk campaigns, contacts, and real-time delivery — all from one unified dashboard built for scale.</p>
        </div>

        <div class="stat-row">
            <div class="stat-chip">
                <div class="stat-chip-value">99.9%</div>
                <div class="stat-chip-label">Uptime SLA</div>
            </div>
            <div class="stat-chip">
                <div class="stat-chip-value">&lt; 2s</div>
                <div class="stat-chip-label">Avg Delivery</div>
            </div>
            <div class="stat-chip">
                <div class="stat-chip-value">∞</div>
                <div class="stat-chip-label">Contacts</div>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="panel-right">

        <div class="form-eyebrow">
            <div class="eyebrow-dot"></div>
            System Online
        </div>

        <h2 class="form-title">Welcome back</h2>
        <p class="form-subtitle">Sign in to continue to your dashboard</p>

        @if (session('status'))
            <div class="alert alert-success">
                <i data-lucide="check-circle" style="width:15px;height:15px;flex-shrink:0;margin-top:1px;"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <i data-lucide="alert-circle" style="width:15px;height:15px;flex-shrink:0;margin-top:1px;"></i>
                <div>@foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach</div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label class="field-label" for="email">Email address</label>
                <div class="field-wrap">
                    <i data-lucide="mail" class="field-icon"></i>
                    <input class="field-input" type="email" id="email" name="email"
                           value="{{ old('email') }}" required autofocus
                           autocomplete="username" placeholder="you@company.com">
                </div>
            </div>

            <div class="field">
                <label class="field-label" for="password">Password</label>
                <div class="field-wrap">
                    <i data-lucide="lock" class="field-icon"></i>
                    <input class="field-input" type="password" id="password" name="password"
                           required autocomplete="current-password" placeholder="••••••••">
                </div>
            </div>

            <div class="row-between">
                <label class="remember">
                    <input type="checkbox" name="remember" id="remember_me">
                    <span class="remember-label">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn-submit">
                <i data-lucide="log-in" style="width:16px;height:16px;"></i>
                Sign In
            </button>
        </form>

        <div class="auth-links" style="text-align: center; margin-top: 24px; font-size: 0.85rem; color: var(--muted);">
            Don't have an account? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Sign up here</a>
        </div>

        <div class="form-footer" style="margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--border); font-size: 0.78rem; color: var(--muted); text-align: center;">
            VetenCall 2026 &nbsp;·&nbsp; Internal Access Only
        </div>

    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
