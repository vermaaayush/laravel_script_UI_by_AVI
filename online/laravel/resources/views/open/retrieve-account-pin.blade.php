<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $bankName ?? 'Equitable Bank' }} - Retrieve PIN</title>
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
            background: #0f131a;
            color: #ffffff;
            padding: 44px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .auth-sidebar::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -30%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(179, 64, 32, 0.35) 0%, transparent 70%);
            filter: blur(40px);
            pointer-events: none;
        }

        .auth-main {
            width: 58%;
            padding: 44px 40px;
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
            border-color: #b34020;
            box-shadow: 0 0 0 4px rgba(179, 64, 32, 0.1);
        }

        .btn-brand-primary {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #b34020 0%, #8c2d13 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 6px 18px rgba(179, 64, 32, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .btn-brand-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(179, 64, 32, 0.35);
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
            background: #fdfaf8;
            border: 1px solid #fae1d9;
            border-radius: 10px;
            color: #b34020;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .quick-nav-btn:hover {
            background: #fbf0ec;
            color: #8c2d13;
            text-decoration: none;
        }

        .quick-nav-btn.full {
            grid-column: span 2;
        }

        .notice-card {
            background: #fff8f6;
            border: 1px solid #f9d7cf;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 12px;
            color: #8c2d13;
            line-height: 1.5;
            margin-top: 14px;
            text-align: left;
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
                    <div class="eyebrow">Credential Service</div>
                    <h2 class="hero-title">Secure PIN Recovery</h2>
                    <p class="hero-desc">Safeguard your accounts with authenticated self-service credential recovery and multi-tier cryptographic verification.</p>
                </div>

                <div class="security-badge-pill">
                    <span class="material-symbols-outlined" style="font-size: 16px;">verified_user</span>
                    <span>256-Bit SSL Encrypted Banking</span>
                </div>
            </div>

            <!-- Right Main Form -->
            <div class="auth-main">
                <h1 class="form-heading">Retrieve Account PIN</h1>
                <p class="form-subtext">Enter your registered User ID to initiate secure PIN validation.</p>

                @include('flash::message')

                <form id="form-wizard1" class="text-center w-100" role="form" method="POST" action="retrieve-account-pin">
                    @csrf
                    
                    @if($otp == 'show2')
                    <!-- Step 3: Set New PIN -->
                    <div class="text-left w-100">
                        <div class="form-group-custom">
                            <label class="form-label-custom">New Account PIN</label>
                            <input type="password" name="pin1" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pin1" class="form-control-custom" placeholder="••••" maxlength="6" value='{{ $pin1 ?? '' }}' required>
                        </div>
                        <div class="form-group-custom">
                            <label class="form-label-custom">Confirm Account PIN</label>
                            <input type="password" name="pin2" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pin2" class="form-control-custom" placeholder="••••" maxlength="6" value='{{ $pin2 ?? '' }}' required>
                        </div>
                        <button type="submit" name="submit" id="pinsequal" class="btn-brand-primary" value="submitpin" style="visibility: hidden;">
                            <span>Confirm & Set PIN</span>
                            <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                        </button>
                        <script>
                            setInterval(function() {
                                var pin1 = document.querySelector("#pin1") ? document.querySelector("#pin1").value : "";
                                var pin2 = document.querySelector("#pin2") ? document.querySelector("#pin2").value : "";
                                if(pin1 === pin2 && pin1.length > 0){
                                    document.querySelector('#pinsequal').style.visibility = 'visible';
                                } else {
                                    document.querySelector('#pinsequal').style.visibility = 'hidden';
                                }
                            }, 200);
                        </script>
                    </div>
                    @endif

                    @if($otp == 'show' or $otp == 'show2')
                    <!-- Step 2: One-Time Password -->
                    <div class="text-left w-100 mt-2">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Enter Email Security OTP</label>
                            <input type="text" class="form-control-custom text-center" style="font-family: monospace; letter-spacing: 4px; font-size: 18px; font-weight: 700;" id="otpcode" name="otp" placeholder="000000" value="@if($otp == 'show2'){{ $otprequired ?? '' }}@endif" required>
                        </div>
                        <button type="submit" name="submit" id="otpsequal" class="btn-brand-primary" value="submitotp">
                            <span>Verify Code</span>
                            <span class="material-symbols-outlined" style="font-size: 18px;">key</span>
                        </button>
                        <div class="notice-card">
                            <strong>Security Policy:</strong> 3 incorrect OTP entries will suspend account access for 24 hours. Contact your relationship officer if you did not request this OTP.
                        </div>
                    </div>
                    @endif

                    <!-- Step 1: User ID -->
                    <div class="text-left w-100">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Account User ID</label>
                            <input type="text" name="user" class="form-control-custom" id="validationCustom06" placeholder="Enter your banking User ID" value='{{ $user ?? '' }}' required>
                        </div>
                        <button type="submit" name="submit" class="btn-brand-primary" value="Next">
                            <span>Proceed to Verification</span>
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
                        <a href="{{ url('retrieve-account-user-id') }}" class="quick-nav-btn full">
                            <span class="material-symbols-outlined" style="font-size: 16px;">person_search</span>
                            <span>Forgot User ID? Retrieve Online</span>
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
