<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — WAGateway 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #6C4FF6;
            --primary-light: #8B72FF;
            --accent: #1E90FF;
            --bg: #060612;
            --card: rgba(255,255,255,0.04);
            --border: rgba(255,255,255,0.08);
            --text: #ffffff;
            --muted: rgba(255,255,255,0.4);
            --input-bg: rgba(255,255,255,0.05);
            --input-focus: rgba(108,79,246,0.15);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            overflow: hidden;
            position: relative;
        }

        /* ── Dot Grid Background ── */
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
            z-index: 0;
        }

        /* ── Radial Glow Spots ── */
        .glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            z-index: 0;
        }
        .glow-1 { width: 500px; height: 500px; background: rgba(108,79,246,0.3); top: -100px; left: -100px; animation: drift1 14s ease-in-out infinite; }
        .glow-2 { width: 400px; height: 400px; background: rgba(30,144,255,0.2); bottom: -80px; right: -80px; animation: drift2 16s ease-in-out infinite; }
        .glow-3 { width: 300px; height: 300px; background: rgba(139,114,255,0.15); top: 50%; left: 50%; transform: translate(-50%,-50%); animation: drift3 12s ease-in-out infinite; }

        @keyframes drift1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(40px,-40px)} }
        @keyframes drift2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-40px,40px)} }
        @keyframes drift3 { 0%,100%{transform:translate(-50%,-50%) scale(1)} 50%{transform:translate(-50%,-50%) scale(1.2)} }

        /* ── Layout: two pane ── */
        .layout {
            position: relative;
            z-index: 10;
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ── Left pane (branding) ── */
        .left-pane {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 80px;
            border-right: 1px solid var(--border);
            background: rgba(108,79,246,0.04);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(108,79,246,0.15);
            border: 1px solid rgba(108,79,246,0.3);
            border-radius: 100px;
            padding: 8px 18px;
            margin-bottom: 48px;
            width: fit-content;
        }
        .brand-badge-dot { width: 8px; height: 8px; background: #6C4FF6; border-radius: 50%; animation: pulse 2s ease-in-out infinite; }
        .brand-badge span { font-size: 0.8rem; font-weight: 600; color: var(--primary-light); letter-spacing: 0.5px; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(0.85)} }

        .left-headline {
            font-size: clamp(2rem, 3.5vw, 3.2rem);
            font-weight: 900;
            color: var(--text);
            line-height: 1.15;
            letter-spacing: -1.5px;
            margin-bottom: 20px;
        }
        .left-headline span {
            background: linear-gradient(135deg, #6C4FF6, #1E90FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .left-desc {
            font-size: 1rem;
            color: var(--muted);
            line-height: 1.7;
            max-width: 380px;
            margin-bottom: 56px;
        }

        .feature-list { display: flex; flex-direction: column; gap: 16px; }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            font-weight: 500;
        }
        .feature-icon {
            width: 36px; height: 36px;
            background: rgba(108,79,246,0.12);
            border: 1px solid rgba(108,79,246,0.2);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            color: var(--primary-light);
        }

        /* ── Right pane (form) ── */
        .right-pane {
            width: 480px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 56px;
            background: rgba(0,0,0,0.2);
        }

        /* ── Logo ── */
        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 48px;
        }
        .logo-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #6C4FF6, #1E90FF);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 20px rgba(108,79,246,0.5);
        }
        .logo-name { font-size: 1.25rem; font-weight: 800; color: #fff; letter-spacing: -0.5px; }

        .form-title { font-size: 1.75rem; font-weight: 800; color: #fff; letter-spacing: -0.5px; margin-bottom: 6px; }
        .form-subtitle { font-size: 0.875rem; color: var(--muted); margin-bottom: 36px; }

        /* ── Form Elements ── */
        .form-group { margin-bottom: 22px; }

        .field-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .field-label label { font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.65); }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px; height: 16px;
            color: rgba(255,255,255,0.25);
            transition: color 0.2s;
            pointer-events: none;
        }

        .field-input {
            width: 100%;
            padding: 13px 16px 13px 46px;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: #fff;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.25s;
            outline: none;
        }
        .field-input::placeholder { color: rgba(255,255,255,0.18); }
        .field-input:focus {
            background: var(--input-focus);
            border-color: rgba(108,79,246,0.6);
            box-shadow: 0 0 0 3px rgba(108,79,246,0.15), inset 0 0 0 1px rgba(108,79,246,0.2);
        }
        .input-wrap:focus-within .input-icon { color: var(--primary-light); }

        /* ── Divider row ── */
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
            -webkit-appearance: none;
            width: 17px; height: 17px;
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 5px;
            background: var(--input-bg);
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            flex-shrink: 0;
        }
        .remember input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
        }
        .remember input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1.5px;
            width: 5px; height: 9px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }
        .remember span { font-size: 0.82rem; color: var(--muted); font-weight: 500; }
        .forgot-link { font-size: 0.82rem; color: var(--primary-light); font-weight: 600; text-decoration: none; transition: opacity 0.2s; }
        .forgot-link:hover { opacity: 0.75; }

        /* ── Submit Button ── */
        .btn-submit {
            position: relative;
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6C4FF6 0%, #1E90FF 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 24px rgba(108,79,246,0.45);
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.18) 50%, transparent 60%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        .btn-submit:hover::before { transform: translateX(100%); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(108,79,246,0.55); }
        .btn-submit:active { transform: translateY(0); }

        /* ── Alerts ── */
        .alert {
            border-radius: 10px;
            padding: 11px 16px;
            font-size: 0.83rem;
            font-weight: 500;
            margin-bottom: 22px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25); color: #f87171; }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25); color: #4ade80; }

        /* ── Bottom tagline ── */
        .tagline {
            margin-top: 32px;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.2);
            text-align: center;
            letter-spacing: 0.3px;
        }

        /* ── Responsive: hide left pane on small screens ── */
        @media (max-width: 900px) {
            .left-pane { display: none; }
            .right-pane { width: 100%; padding: 40px 28px; }
        }
    </style>
</head>
<body>

    <!-- Background -->
    <div class="bg-grid"></div>
    <div class="glow glow-1"></div>
    <div class="glow glow-2"></div>
    <div class="glow glow-3"></div>

    <div class="layout">

        <!-- ── Left Pane ── -->
        <div class="left-pane">
            <div class="brand-badge">
                <div class="brand-badge-dot"></div>
                <span>System Online · Live Sync Active</span>
            </div>

            <h1 class="left-headline">
                The smarter way to<br>manage <span>WhatsApp</span><br>campaigns.
            </h1>
            <p class="left-desc">
                WAGateway gives you full control over your bulk messaging, contacts, and campaign analytics — all in one powerful dashboard.
            </p>

            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i data-lucide="radio" style="width:16px;height:16px;"></i>
                    </div>
                    <span>Broadcast campaigns to thousands instantly</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i data-lucide="zap" style="width:16px;height:16px;"></i>
                    </div>
                    <span>Quick Blast for rapid one-off messages</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i data-lucide="bar-chart-2" style="width:16px;height:16px;"></i>
                    </div>
                    <span>Real-time delivery & analytics tracking</span>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i data-lucide="shield-check" style="width:16px;height:16px;"></i>
                    </div>
                    <span>Secure, auth-protected access</span>
                </div>
            </div>
        </div>

        <!-- ── Right Pane ── -->
        <div class="right-pane">

            <div class="logo-wrap">
                <div class="logo-icon">
                    <i data-lucide="zap" style="color:white;width:20px;height:20px;"></i>
                </div>
                <span class="logo-name">WAGateway</span>
            </div>

            <h2 class="form-title">Welcome back</h2>
            <p class="form-subtitle">Enter your credentials to continue</p>

            @if (session('status'))
                <div class="alert alert-success">
                    <i data-lucide="check-circle" style="width:15px;height:15px;flex-shrink:0;margin-top:1px;"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <i data-lucide="alert-circle" style="width:15px;height:15px;flex-shrink:0;margin-top:1px;"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <div class="field-label">
                        <label for="email">Email Address</label>
                    </div>
                    <div class="input-wrap">
                        <i data-lucide="mail" class="input-icon"></i>
                        <input type="email" id="email" name="email" class="field-input"
                               value="{{ old('email') }}" required autofocus
                               autocomplete="username" placeholder="you@example.com">
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <div class="field-label">
                        <label for="password">Password</label>
                    </div>
                    <div class="input-wrap">
                        <i data-lucide="lock" class="input-icon"></i>
                        <input type="password" id="password" name="password" class="field-input"
                               required autocomplete="current-password" placeholder="••••••••">
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="row-between">
                    <label class="remember">
                        <input type="checkbox" name="remember" id="remember_me">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    <i data-lucide="log-in" style="width:17px;height:17px;"></i>
                    Sign In
                </button>
            </form>

            <p class="tagline">WAGateway 2026 · All rights reserved</p>
        </div>

    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
