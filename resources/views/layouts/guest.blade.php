<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Trans Bony - Plateforme professionnelle de gestion de flotte de transport">
    <title>Trans Bony — Connexion</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary:       #3b82f6;
            --primary-dark:  #1d4ed8;
            --primary-light: #93c5fd;
            --accent:        #8b5cf6;
            --accent-dark:   #6d28d9;
            --surface:       rgba(255, 255, 255, 0.07);
            --border:        rgba(255, 255, 255, 0.15);
            --text-light:    rgba(255, 255, 255, 0.85);
            --text-muted:    rgba(255, 255, 255, 0.5);
            --danger:        #ef4444;
            --radius:        14px;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        /* ─── LAYOUT ─────────────────────────────────────────────── */
        .auth-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* ─── LEFT PANEL (hero) ──────────────────────────────────── */
        .auth-hero {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
        }

        /* Animated background image */
        .auth-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('/images/bg-truck.jpg') center center / cover no-repeat;
            opacity: 0.25;
            animation: bgZoom 20s ease-in-out infinite alternate;
        }

        @keyframes bgZoom {
            from { transform: scale(1);    }
            to   { transform: scale(1.08); }
        }

        /* Blue-to-purple gradient overlay */
        .auth-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(15, 23, 42, 0.70) 0%,
                rgba(30, 58, 138, 0.60) 50%,
                rgba(109, 40, 217, 0.55) 100%
            );
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 48px 32px;
            max-width: 520px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(59, 130, 246, 0.2);
            border: 1px solid rgba(59, 130, 246, 0.4);
            border-radius: 50px;
            padding: 6px 18px;
            font-size: 12px;
            font-weight: 600;
            color: var(--primary-light);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 28px;
            backdrop-filter: blur(8px);
        }

        .hero-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 28px;
        }

        .hero-logo-icon {
            width: 68px;
            height: 68px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.4);
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0);   }
            50%       { transform: translateY(-8px); }
        }

        .hero-title {
            font-size: 42px;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
        }

        .hero-title span {
            background: linear-gradient(90deg, var(--primary-light), #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 48px;
        }

        /* Stats row */
        .hero-stats {
            display: flex;
            gap: 24px;
            justify-content: center;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 24px;
            text-align: center;
            backdrop-filter: blur(12px);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(59, 130, 246, 0.5);
        }

        .stat-number {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            line-height: 1;
        }

        .stat-label {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* Decorative orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: rgba(59, 130, 246, 0.25);
            top: -120px;
            left: -120px;
            animation: orbFloat1 12s ease-in-out infinite alternate;
        }

        .orb-2 {
            width: 350px;
            height: 350px;
            background: rgba(139, 92, 246, 0.20);
            bottom: -80px;
            right: -80px;
            animation: orbFloat2 15s ease-in-out infinite alternate;
        }

        @keyframes orbFloat1 {
            from { transform: translate(0,0);         }
            to   { transform: translate(40px, 40px);  }
        }

        @keyframes orbFloat2 {
            from { transform: translate(0,0);          }
            to   { transform: translate(-30px,-30px);  }
        }

        /* ─── RIGHT PANEL (form) ─────────────────────────────────── */
        .auth-form-panel {
            width: 480px;
            min-width: 380px;
            background: #0f172a;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            position: relative;
            overflow-y: auto;
        }

        .auth-form-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(
                to bottom,
                transparent,
                rgba(59, 130, 246, 0.6),
                rgba(139, 92, 246, 0.6),
                transparent
            );
        }

        .form-container {
            width: 100%;
            max-width: 380px;
            animation: slideInRight 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0);    }
        }

        /* Form header */
        .form-header {
            margin-bottom: 36px;
        }

        .form-eyebrow {
            font-size: 12px;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 10px;
        }

        .form-title {
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .form-desc {
            margin-top: 8px;
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ─── INPUT GROUPS ────────────────────────────────────────── */
        .input-group {
            margin-bottom: 20px;
        }

        .input-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            font-size: 15px;
            transition: color 0.3s ease;
            pointer-events: none;
        }

        .auth-input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: #fff;
            outline: none;
            transition: all 0.3s ease;
            caret-color: var(--primary);
        }

        .auth-input::placeholder {
            color: rgba(255,255,255,0.25);
        }

        .auth-input:focus {
            border-color: var(--primary);
            background: rgba(59, 130, 246, 0.08);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
            transform: none; /* override app.blade global */
        }

        .auth-input:focus + .focus-ring {
            opacity: 1;
        }

        .input-wrapper:focus-within .input-icon {
            color: var(--primary-light);
        }

        /* Password toggle */
        .pwd-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255,255,255,0.3);
            font-size: 14px;
            transition: color 0.3s ease;
            padding: 4px;
        }

        .pwd-toggle:hover {
            color: var(--primary-light);
        }

        /* ─── REMEMBER & FORGOT ──────────────────────────────────── */
        .form-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13px;
            color: rgba(255,255,255,0.5);
            transition: color 0.2s;
        }

        .remember-label:hover {
            color: rgba(255,255,255,0.8);
        }

        .remember-checkbox {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1.5px solid rgba(255,255,255,0.2);
            background: transparent;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s, text-decoration 0.2s;
        }

        .forgot-link:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        /* ─── SUBMIT BUTTON ───────────────────────────────────────── */
        .btn-submit {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: var(--radius);
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.35);
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary-dark), var(--accent-dark));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-submit:hover::before {
            opacity: 1;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(59, 130, 246, 0.45);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit span {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* Shimmer effect on button */
        .btn-submit::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -75%;
            width: 50%;
            height: 200%;
            background: linear-gradient(
                to right,
                transparent,
                rgba(255,255,255,0.18),
                transparent
            );
            transform: skewX(-20deg);
            transition: left 0.55s ease;
        }

        .btn-submit:hover::after {
            left: 130%;
        }

        /* ─── DIVIDER ─────────────────────────────────────────────── */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 28px 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.08);
        }

        .divider-text {
            font-size: 11px;
            color: rgba(255,255,255,0.3);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            white-space: nowrap;
        }

        /* ─── REGISTER LINK ───────────────────────────────────────── */
        .register-prompt {
            text-align: center;
            font-size: 13px;
            color: rgba(255,255,255,0.4);
        }

        .register-prompt a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .register-prompt a:hover {
            color: var(--primary-light);
        }

        /* ─── ERROR MESSAGES ──────────────────────────────────────── */
        .error-box {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: var(--radius);
            padding: 14px 16px;
            margin-bottom: 24px;
            animation: shakeIn 0.4s ease;
        }

        @keyframes shakeIn {
            0%   { transform: translateX(-6px); opacity: 0; }
            30%  { transform: translateX(6px);  }
            60%  { transform: translateX(-4px); }
            80%  { transform: translateX(4px);  }
            100% { transform: translateX(0);    opacity: 1; }
        }

        .error-box ul {
            list-style: none;
            padding: 0;
        }

        .error-box li {
            font-size: 13px;
            color: #fca5a5;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error-box li::before {
            content: '\f06a';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 12px;
            color: var(--danger);
        }

        /* ─── FOOTER ───────────────────────────────────────────────── */
        .form-footer {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.06);
            text-align: center;
        }

        .form-footer p {
            font-size: 11.5px;
            color: rgba(255,255,255,0.2);
            letter-spacing: 0.04em;
        }

        /* ─── RESPONSIVE ─────────────────────────────────────────── */
        @media (max-width: 820px) {
            .auth-hero {
                display: none;
            }

            .auth-form-panel {
                width: 100%;
                min-width: unset;
                padding: 40px 24px;
            }

            .auth-form-panel::before {
                display: none;
            }

            .auth-wrapper {
                background: #0f172a;
            }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <!-- ═══ LEFT: HERO SECTION ═════════════════════════════ -->
    <div class="auth-hero">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>

        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-truck-fast"></i>
                Plateforme de gestion de flotte
            </div>

            <div class="hero-logo">
                <div class="hero-logo-icon">
                    <i class="fas fa-truck-fast"></i>
                </div>
            </div>

            <h1 class="hero-title">
                TRANS <span>BONY</span>
            </h1>

            <p class="hero-subtitle">
                Gérez votre flotte, vos chauffeurs et vos opérations&nbsp;—
                tout en un seul endroit, avec une visibilité en temps réel.
            </p>

            <div class="hero-stats">
                <div class="stat-card">
                    <div class="stat-number">12+</div>
                    <div class="stat-label">Véhicules</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Chauffeurs</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">99%</div>
                    <div class="stat-label">Disponibilité</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ RIGHT: FORM SECTION ═══════════════════════════ -->
    <div class="auth-form-panel">
        @yield('content')
    </div>
</div>

</body>
</html>
