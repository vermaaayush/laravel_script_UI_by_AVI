<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $bankName ?? 'Equitable Bank' }} - Retrieve User ID</title>
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
                radial-gradient(circle at 10% 20%, rgba(197, 155, 39, 0.06) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(15, 19, 26, 0.04) 0%, transparent 40%);
            color: #0f131a;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-container {
            width: 100%;
            max-width: 860px;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 25px 60px -15px rgba(15, 19, 26, 0.08), 0 0 0 1px rgba(226, 230, 237, 0.9);
            overflow: hidden;
            display: flex;
            min-height: 520px;
        }

        .auth-sidebar {
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

        .auth-sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(10, 14, 23, 0.45) 0%, rgba(10, 14, 23, 0.90) 100%);
            border-radius: 20px;
            z-index: 1;
        }

        .auth-sidebar > * {
            position: relative;
            z-index: 2;
        }

        .auth-main {
            width: 58%;
            padding: 36px 34px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        @media (max-width: 820px) {
            .auth-card { flex-direction: column; }
            .auth-sidebar { width: 100%; padding: 30px; }
            .auth-main { width: 100%; padding: 30px 24px; }
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
            color: #dfbb58;
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

        .security-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 8px 14px;
            border-radius: 9999px;
            font-size: 12px;
            color: #cbd5e1;
        }

        .form-heading {
            font-size: 22px;
            font-weight: 800;
            color: #0f131a;
            margin: 0 0 6px 0;
            letter-spacing: -0.02em;
        }

        .form-subtext {
            font-size: 13.5px;
            color: #5f6b7c;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .form-group-custom {
            margin-bottom: 18px;
            text-align: left;
        }

        .form-label-custom {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: #2b3545;
            margin-bottom: 6px;
        }

        .form-control-custom {
            width: 100%;
            height: 46px;
            padding: 0 16px;
            font-size: 14px;
            font-weight: 500;
            color: #0f131a;
            background: #f8f9fb;
            border: 1.5px solid #e2e6ed;
            border-radius: 12px;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            background: #ffffff;
            border-color: #c59b27;
            box-shadow: 0 0 0 3px rgba(197, 155, 39, 0.15);
        }

        .question-box {
            background: #faf8f2;
            border: 1px solid #ebd9ab;
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 18px;
            text-align: left;
        }

        .question-box-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #c59b27;
            margin-bottom: 4px;
        }

        .question-box-title {
            font-size: 14.5px;
            font-weight: 700;
            color: #0f131a;
            margin: 0;
            line-height: 1.4;
        }

        .btn-brand-primary {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #dfbb58 0%, #c59b27 50%, #9c7614 100%);
            border: none;
            border-radius: 12px;
            color: #0a0e17;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(197, 155, 39, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .btn-brand-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(197, 155, 39, 0.4);
            background: linear-gradient(135deg, #e9c668 0%, #d4aa33 50%, #aa821c 100%);
        }

        .quick-nav-box {
            margin-top: 26px;
            padding-top: 20px;
            border-top: 1px solid #eef1f5;
        }

        .quick-nav-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #8b949e;
            margin-bottom: 10px;
            text-align: left;
        }

        .quick-nav-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .quick-nav-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            background: #faf8f2;
            border: 1px solid #ebd9ab;
            border-radius: 10px;
            color: #9c7614;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .quick-nav-btn:hover {
            background: #f4ecda;
            color: #7b5b08;
            text-decoration: none;
        }

        .quick-nav-btn.full {
            grid-column: span 2;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            
            <!-- Left Brand Sidebar -->
            <div class="auth-sidebar">
                <div>
                    <img src="//{{ isset($bank_url) ? $bank_url : Session::get('bank_url') }}/admin/uploads/{{ $logo }}" onerror="this.src='images/logo-full.png';" class="brand-logo-img" alt="Logo">
                </div>
                
                <div class="my-auto py-4">
                    <div class="eyebrow">Identity Recovery</div>
                    <h2 class="hero-title">Locate Your User ID</h2>
                    <p class="hero-desc">Provide your registered primary email address to recover your online client banking identification details.</p>
                </div>

                <div class="security-badge-pill">
                    <span class="material-symbols-outlined" style="font-size: 16px;">shield_lock</span>
                    <span>Direct Encrypted Dispatch</span>
                </div>
            </div>

            <!-- Right Main Form -->
            <div class="auth-main">
                <h1 class="form-heading">Retrieve User ID</h1>
                <p class="form-subtext">Enter your registered email address to receive your User ID credentials.</p>

                @include('flash::message')

                <form id="form-wizard1" class="text-center w-100" method="POST" action="retrieve-account-user-id">
                    @csrf

                    @if($otp == 'show')
                    <!-- Security Question Step -->
                    <div class="text-left w-100">
                        <div class="question-box">
                            <div class="question-box-label">Security Question</div>
                            <div class="question-box-title">{{ $qid2 ?? 'Answer your secret security question' }}</div>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Security Answer</label>
                            <input type="text" class="form-control-custom" name="qid2" placeholder="Your Answer" required>
                        </div>

                        <button type="submit" name="submitotp" class="btn-brand-primary" value="submit">
                            <span>Confirm Answer</span>
                            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                        </button>
                        <p class="text-muted text-center mt-2" style="font-size: 12px;">(You designated this answer during registration)</p>
                    </div>
                    @endif

                    <!-- Default Email Input Step -->
                    <div class="text-left w-100">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Registered Email Address</label>
                            <input type="email" name="email" class="form-control-custom" placeholder="client@example.com" value='{{ $email ?? '' }}' required>
                        </div>
                        <button type="submit" name="next" class="btn-brand-primary" value="Next">
                            <span>Locate Account User ID</span>
                            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                        </button>
                    </div>
                </form>

                <!-- Navigation Links -->
                <div class="quick-nav-box">
                    <div class="quick-nav-title">Self-Service Hub</div>
                    <div class="quick-nav-grid">
                        <a href="{{ url('online-open-account') }}" class="quick-nav-btn">
                            <span class="material-symbols-outlined" style="font-size: 16px;">add_circle</span>
                            <span>Open Account</span>
                        </a>
                        <a href="{{ url('login') }}" class="quick-nav-btn">
                            <span class="material-symbols-outlined" style="font-size: 16px;">login</span>
                            <span>Client Sign In</span>
                        </a>
                        <a href="{{ url('retrieve-account-pin') }}" class="quick-nav-btn full">
                            <span class="material-symbols-outlined" style="font-size: 16px;">pin</span>
                            <span>Forgot PIN? Retrieve PIN Online</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        jQuery('div.alert').not('.alert-important').delay(10000).fadeOut(15000);
    </script>
</body>
</html>
