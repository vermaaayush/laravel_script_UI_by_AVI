<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $bankName ?? 'Equitable Bank' }} - Digital Banking Registration</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        :root {
            --primary-gold: #c59b27;
            --primary-gold-light: #dfbb58;
            --primary-gold-dark: #9c7614;
            --bg-page: #f8f9fb;
            --card-bg: #ffffff;
            --text-main: #0a0e17;
            --text-muted: #5f6b7c;
            --border-color: #e2e6ed;
        }

        body.dark-theme {
            --bg-page: #080c13;
            --card-bg: #101622;
            --text-main: #f0f6fc;
            --text-muted: #8b949e;
            --border-color: #212936;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(197, 155, 39, 0.06) 0%, transparent 45%),
                radial-gradient(circle at 90% 80%, rgba(10, 14, 23, 0.05) 0%, transparent 45%);
            color: var(--text-main);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reg-container {
            width: 100%;
            max-width: 980px;
        }

        .reg-card {
            background: var(--card-bg);
            border-radius: 28px;
            box-shadow: 0 25px 60px -15px rgba(10, 14, 23, 0.12), 0 0 0 1px var(--border-color);
            overflow: hidden;
            display: flex;
            padding: 16px;
            gap: 16px;
        }

        .reg-sidebar {
            width: 42%;
            background-image: url('{{ asset("images/auth_luxury_banner.jpg") }}');
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            color: #ffffff;
            padding: 34px 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(197, 155, 39, 0.25);
        }

        .reg-sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(10, 14, 23, 0.45) 0%, rgba(10, 14, 23, 0.90) 100%);
            border-radius: 20px;
            z-index: 1;
        }

        .reg-sidebar > * {
            position: relative;
            z-index: 2;
        }

        .reg-main {
            width: 58%;
            padding: 30px 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (max-width: 860px) {
            .reg-card { flex-direction: column; }
            .reg-sidebar { width: 100%; min-height: 260px; }
            .reg-main { width: 100%; padding: 20px 14px; }
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 30px;
            background: rgba(197, 155, 39, 0.25);
            color: #dfbb58;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 12px;
            border: 1px solid rgba(197, 155, 39, 0.35);
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            line-height: 1.25;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .hero-desc {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .reg-sidebar-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .reg-sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none !important;
            transition: all 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .reg-sidebar-link:hover {
            background: rgba(197, 155, 39, 0.35);
            color: #ffffff;
            transform: translateX(3px);
        }

        .main-heading {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 6px 0;
            letter-spacing: -0.5px;
        }

        .main-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 22px;
        }

        .checklist-box {
            background: #f8fafc;
            border: 1.5px solid var(--border-color);
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 20px;
        }

        body.dark-theme .checklist-box {
            background: #0d121c;
        }

        .checklist-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #c59b27;
            margin-bottom: 12px;
        }

        .checklist-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 13px;
            color: var(--text-main);
            line-height: 1.45;
        }

        .checklist-item:last-child {
            margin-bottom: 0;
        }

        .checklist-icon {
            color: #10b981;
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .info-step-card {
            border-left: 3px solid #c59b27;
            padding-left: 14px;
            margin-bottom: 24px;
            font-size: 12.5px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .btn-brand-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 48px;
            padding: 0 28px;
            background: linear-gradient(135deg, #dfbb58 0%, #c59b27 50%, #9c7614 100%);
            border: none;
            border-radius: 14px;
            color: #0a0e17;
            font-size: 14px;
            font-weight: 800;
            text-decoration: none !important;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(197, 155, 39, 0.3);
        }

        .btn-brand-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(197, 155, 39, 0.4);
            color: #0a0e17;
            background: linear-gradient(135deg, #e9c668 0%, #d4aa33 50%, #aa821c 100%);
        }
    </style>
</head>
<body>
    <div class="reg-container">
        <div class="reg-card">
            
            <!-- Left Info Sidebar with Auth Luxury Banner -->
            <div class="reg-sidebar">
                <div>
                    <div class="eyebrow">
                        <span class="material-symbols-outlined text-[14px]">verified</span>
                        Client Enrollment
                    </div>
                    <h2 class="hero-title">Digital Private Banking Enrollment</h2>
                    <p class="hero-desc">Registering your account for institutional online access takes only a few moments. Follow our step-by-step workflow.</p>
                </div>

                <div class="reg-sidebar-links">
                    <a href="{{ url('online-open-account') }}" class="reg-sidebar-link">
                        <span class="material-symbols-outlined text-[17px]">account_balance</span>
                        <span>Open New Bank Account</span>
                    </a>
                    <a href="{{ url('retrieve-account-pin') }}" class="reg-sidebar-link">
                        <span class="material-symbols-outlined text-[17px]">pin</span>
                        <span>Retrieve Account PIN</span>
                    </a>
                    <a href="{{ url('retrieve-account-user-id') }}" class="reg-sidebar-link">
                        <span class="material-symbols-outlined text-[17px]">badge</span>
                        <span>Retrieve User ID</span>
                    </a>
                </div>
            </div>

            <!-- Right Content -->
            <div class="reg-main">
                <div>
                    <h1 class="main-heading">Get Started with Online Banking</h1>
                    <p class="main-subtitle">{{ $bankName ?? 'Equitable Bank' }} Client Self-Registration</p>

                    <div class="checklist-box">
                        <div class="checklist-title">Requirements for Registration</div>
                        <div class="checklist-item">
                            <span class="material-symbols-outlined checklist-icon">check_circle</span>
                            <span>Your legal registered name, physical address, and mobile number.</span>
                        </div>
                        <div class="checklist-item">
                            <span class="material-symbols-outlined checklist-icon">check_circle</span>
                            <span>Your primary account number issued by {{ $bankName ?? 'our institution' }}.</span>
                        </div>
                        <div class="checklist-item">
                            <span class="material-symbols-outlined checklist-icon">check_circle</span>
                            <span>Active debit or credit card issued under your account profile.</span>
                        </div>
                    </div>

                    <div class="info-step-card">
                        During the enrollment process, you will configure your unique User ID, cryptographic security PIN, and set up secondary security questions.
                    </div>
                </div>

                <div>
                    <a href="{{ url('newaccount-steps') }}" class="btn-brand-primary">
                        <span>Continue to Registration</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                    <p style="font-size: 11.5px; color: var(--text-muted); margin-top: 14px;">
                        Already registered? <a href="{{ url('login') }}" style="color: #c59b27; font-weight: 700;">Sign in to your account</a>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>
