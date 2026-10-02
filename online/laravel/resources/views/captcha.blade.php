<?php
    if (!function_exists('generateCaptcha')) {
        function generateCaptcha($length = 5) {
            $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
            $captcha = '';
            for ($i = 0; $i < $length; $i++) {
                $captcha .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $captcha;
        }
    }
    $captchaCode = generateCaptcha(5);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $bankName ?? 'Equitable Bank' }} - Security Verification</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        :root {
            --primary-gold: #c59b27;
            --primary-gold-light: #dfbb58;
            --primary-gold-dark: #9c7614;
            --primary-gradient: linear-gradient(135deg, #dfbb58 0%, #c59b27 50%, #9c7614 100%);
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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(197, 155, 39, 0.06) 0%, transparent 45%),
                radial-gradient(circle at 90% 80%, rgba(10, 14, 23, 0.05) 0%, transparent 45%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .split-card-container {
            width: 100%;
            max-width: 960px;
            background: var(--card-bg);
            border-radius: 28px;
            box-shadow: 0 25px 60px -12px rgba(10, 14, 23, 0.12), 0 0 0 1px var(--border-color);
            display: flex;
            align-items: stretch;
            position: relative;
            overflow: hidden;
            padding: 16px;
            gap: 16px;
        }

        /* Left Side: Form */
        .form-side {
            flex: 1.1;
            padding: 24px 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .logo-box {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none !important;
            margin-bottom: 24px;
        }

        .logo-fallback-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #121824 0%, #0a0e17 100%);
            border: 1px solid rgba(197, 155, 39, 0.4);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #dfbb58;
        }

        .logo-title {
            font-weight: 800;
            font-size: 15px;
            letter-spacing: -0.3px;
            color: var(--text-main);
            text-transform: uppercase;
        }

        h2 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
        }

        .instruction-text {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .captcha-display-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f4f6fa;
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            padding: 10px 18px;
            margin-bottom: 18px;
        }

        body.dark-theme .captcha-display-box {
            background: #141b27;
        }

        .captcha-code-text {
            font-family: 'JetBrains Mono', monospace;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 7px;
            color: #c59b27;
            user-select: none;
        }

        .refresh-btn {
            background: rgba(197, 155, 39, 0.15);
            color: #9c7614;
            border: none;
            border-radius: 10px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .refresh-btn:hover {
            background: #c59b27;
            color: #ffffff;
            transform: rotate(180deg);
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            margin-bottom: 20px;
            transition: all 0.2s ease;
        }

        body.dark-theme .input-wrapper {
            background: #0d121c;
        }

        .input-wrapper:focus-within {
            border-color: #c59b27;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(197, 155, 39, 0.15);
        }

        .field-icon-left {
            padding-left: 16px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        .form-control-custom {
            border: none !important;
            background: transparent !important;
            height: 48px !important;
            width: 100%;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main) !important;
            padding: 0 14px !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .btn-verify {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #dfbb58 0%, #c59b27 50%, #9c7614 100%);
            border: none;
            border-radius: 14px;
            color: #0a0e17;
            font-size: 14px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(197, 155, 39, 0.3);
        }

        .btn-verify:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(197, 155, 39, 0.4);
            background: linear-gradient(135deg, #e9c668 0%, #d4aa33 50%, #aa821c 100%);
        }

        /* Right Side: Luxury Architecture Lounge Banner */
        .banner-side {
            flex: 1;
            background-image: url('{{ asset("images/auth_luxury_banner.jpg") }}');
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 32px 28px;
            overflow: hidden;
            border: 1px solid rgba(197, 155, 39, 0.25);
        }

        .banner-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(10, 14, 23, 0.35) 0%, rgba(10, 14, 23, 0.88) 100%);
            border-radius: 20px;
            z-index: 1;
        }

        .banner-content {
            position: relative;
            z-index: 2;
            color: #ffffff;
        }

        .banner-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(197, 155, 39, 0.25);
            backdrop-filter: blur(10px);
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
            color: #dfbb58;
            border: 1px solid rgba(197, 155, 39, 0.4);
            align-self: flex-start;
        }

        .banner-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            line-height: 1.25;
            color: #ffffff;
            margin: 0 0 6px 0;
        }

        .banner-subtitle {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.82);
            line-height: 1.5;
            margin: 0;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .shake {
            animation: shake 0.4s ease-in-out;
            border-color: #ef4444 !important;
        }

        @media (max-width: 820px) {
            .split-card-container { flex-direction: column; }
            .banner-side { min-height: 240px; }
            .form-side { padding: 18px 14px; }
        }
    </style>
</head>
<body>
    <div class="split-card-container">
        <!-- Form Left -->
        <div class="form-side">
            <div>
                <a href="{{ url('/') }}" class="logo-box">
                    <div class="logo-fallback-icon">
                        <span class="material-symbols-outlined text-[20px]">account_balance</span>
                    </div>
                    <span class="logo-title">{{ $bankName ?? 'Equitable Bank' }}</span>
                </a>

                <h2>Security Checkpoint</h2>
                <p class="instruction-text">
                    To safeguard institutional accounts, please verify the secure cryptographic session code below.
                </p>

                <div class="captcha-display-box">
                    <span class="captcha-code-text" id="captcha"><?php echo $captchaCode; ?></span>
                    <button type="button" class="refresh-btn" id="refreshBtn" title="Generate New Code">
                        <span class="material-symbols-outlined text-[18px]">refresh</span>
                    </button>
                </div>

                <form id="captchaForm" action="{{ url('captcha') }}" method="GET" onsubmit="return validateForm(event);">
                    <div class="input-wrapper" id="inputWrap">
                        <span class="field-icon-left">
                            <span class="material-symbols-outlined text-[19px]">verified_user</span>
                        </span>
                        <input type="text" class="form-control-custom" id="enteredCaptcha" placeholder="Enter security code above" name="enteredCaptcha" required autocomplete="off">
                    </div>

                    <button type="submit" class="btn-verify">
                        <span>Verify & Continue</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </form>
            </div>

            <p style="font-size: 11.5px; color: var(--text-muted); margin-top: 18px; text-align: center;">
                Protected by 256-Bit TLS Encryption & Device Fingerprinting
            </p>
        </div>

        <!-- Banner Right -->
        <div class="banner-side">
            <div class="banner-overlay"></div>
            
            <div class="relative z-10">
                <div class="banner-badge">
                    <span class="material-symbols-outlined text-[15px]">security</span>
                    Institutional Security
                </div>
            </div>

            <div class="banner-content">
                <h1 class="banner-title">Uncompromising Defense for Sovereign Capital.</h1>
                <p class="banner-subtitle">Real-time threat monitoring and multi-layer biometric defenses ensuring uninterrupted wealth preservation.</p>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script>
        function generateCaptchaStr(length) {
            var chars = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
            var result = '';
            for (var i = 0; i < length; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return result;
        }

        $('#refreshBtn').click(function() {
            var newCode = generateCaptchaStr(5);
            $('#captcha').text(newCode);
            $('#enteredCaptcha').val('').removeClass('shake');
        });

        function validateForm(e) {
            var currentCaptcha = $('#captcha').text().trim().toUpperCase();
            var entered = $('#enteredCaptcha').val().trim().toUpperCase();

            if (entered !== currentCaptcha) {
                e.preventDefault();
                $('#inputWrap').addClass('shake');
                setTimeout(function() {
                    $('#inputWrap').removeClass('shake');
                }, 600);
                alert('Invalid security verification code. Please try again.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
