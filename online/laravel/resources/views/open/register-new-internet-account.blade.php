<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $bankName ?? 'Equitable Bank' }} - Digital Banking Registration</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8f9fb;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(179, 64, 32, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(15, 19, 26, 0.04) 0%, transparent 40%);
            color: #0f131a;
            margin: 0;
            padding: 24px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reg-container {
            width: 100%;
            max-width: 920px;
        }

        .reg-card {
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 25px 60px -15px rgba(15, 19, 26, 0.08), 0 0 0 1px rgba(226, 230, 237, 0.9);
            overflow: hidden;
            display: flex;
        }

        .reg-sidebar {
            width: 38%;
            background: #0f131a;
            color: #ffffff;
            padding: 44px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .reg-sidebar::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -20%;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(179, 64, 32, 0.35) 0%, transparent 70%);
            filter: blur(40px);
            pointer-events: none;
        }

        .reg-main {
            width: 62%;
            padding: 44px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (max-width: 840px) {
            .reg-card { flex-direction: column; }
            .reg-sidebar { width: 100%; padding: 30px; }
            .reg-main { width: 100%; padding: 30px 24px; }
        }

        .brand-logo-img {
            max-height: 38px;
            max-width: 180px;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .eyebrow {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #d25a3a;
            margin-bottom: 8px;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 600;
            line-height: 1.25;
            color: #ffffff;
            margin-bottom: 12px;
        }

        .hero-desc {
            font-size: 13px;
            color: #94a3b8;
            line-height: 1.55;
            margin: 0;
        }

        .reg-sidebar-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 24px;
        }

        .reg-sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #e2e8f0;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .reg-sidebar-link:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            text-decoration: none;
        }

        .main-heading {
            font-size: 24px;
            font-weight: 800;
            color: #0f131a;
            margin: 0 0 6px 0;
            letter-spacing: -0.02em;
        }

        .main-subtitle {
            font-size: 13.5px;
            color: #5f6b7c;
            margin-bottom: 24px;
        }

        .checklist-box {
            background: #f8f9fb;
            border: 1px solid #e2e6ed;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .checklist-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #b34020;
            margin-bottom: 12px;
        }

        .checklist-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 13px;
            color: #2b3545;
            line-height: 1.45;
        }

        .checklist-item:last-child {
            margin-bottom: 0;
        }

        .checklist-icon {
            color: #10b981;
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .info-step-card {
            border-left: 3px solid #b34020;
            padding-left: 14px;
            margin-bottom: 24px;
            font-size: 13px;
            color: #5f6b7c;
            line-height: 1.5;
        }

        .btn-brand-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 48px;
            padding: 0 28px;
            background: linear-gradient(135deg, #b34020 0%, #8c2d13 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 6px 18px rgba(179, 64, 32, 0.25);
        }

        .btn-brand-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(179, 64, 32, 0.35);
            color: #ffffff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="reg-container">
        <div class="reg-card">
            
            <!-- Left Info Sidebar -->
            <div class="reg-sidebar">
                <div>
                    <img src="//{{ isset($bank_url) ? $bank_url : Session::get('bank_url') }}/admin/uploads/{{ $logo }}" onerror="this.src='images/logo-full.png';" class="brand-logo-img" alt="Logo">
                </div>
                
                <div class="my-4">
                    <div class="eyebrow">Client Enrollment</div>
                    <h2 class="hero-title">Internet Banking Registration</h2>
                    <p class="hero-desc">Registering your account for online access takes only a few moments. Follow our step-by-step verified enrollment workflow.</p>
                </div>

                <div class="reg-sidebar-links">
                    <a href="{{ url('online-open-account') }}" class="reg-sidebar-link">
                        <span class="material-symbols-outlined" style="font-size: 16px;">account_balance</span>
                        <span>Open New Bank Account</span>
                    </a>
                    <a href="{{ url('retrieve-account-pin') }}" class="reg-sidebar-link">
                        <span class="material-symbols-outlined" style="font-size: 16px;">pin</span>
                        <span>Retrieve Account PIN</span>
                    </a>
                    <a href="{{ url('retrieve-account-user-id') }}" class="reg-sidebar-link">
                        <span class="material-symbols-outlined" style="font-size: 16px;">badge</span>
                        <span>Retrieve User ID</span>
                    </a>
                </div>
            </div>

            <!-- Right Content -->
            <div class="reg-main">
                <h1 class="main-heading">Get Started with Online Banking</h1>
                <p class="main-subtitle">{{ $bankName ?? 'Equitable Bank' }} Client Self-Registration</p>

                <div class="checklist-box">
                    <div class="checklist-title">Requirements for Registration</div>
                    <div class="checklist-item">
                        <span class="material-symbols-outlined checklist-icon">check_circle</span>
                        <span>Your legal registered name, physical address, and contact information.</span>
                    </div>
                    <div class="checklist-item">
                        <span class="material-symbols-outlined checklist-icon">check_circle</span>
                        <span>Your primary sort code or existing account number with {{ $bankName ?? 'our institution' }}.</span>
                    </div>
                    <div class="checklist-item">
                        <span class="material-symbols-outlined checklist-icon">check_circle</span>
                        <span>Active debit card or credit card issued under your account profile.</span>
                    </div>
                </div>

                <div class="info-step-card">
                    During the registration process, you will establish unique login credentials, secondary security answers, and configure your preferred 2FA token channels.
                </div>

                <div>
                    <a href="newaccount-steps" class="btn-brand-primary">
                        <span>Continue to Registration</span>
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
