<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $bankName ?? 'Equitable Bank' }} - Security Verification</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://code.jquery.com/ui/1.9.0/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
    <link href="{{ asset('css/keyboard.css') }}" rel="stylesheet">
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
            padding: 16px;
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

        .form-side {
            flex: 1.1;
            padding: 24px 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 9999px;
            background: rgba(197, 155, 39, 0.15);
            color: #9c7614;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 16px;
            align-self: flex-start;
        }

        .logo-wrap {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
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
            margin: 0 0 6px 0;
            letter-spacing: -0.5px;
        }

        .subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .question-box {
            background: #f8fafc;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 20px;
            border: 1.5px solid var(--border-color);
            position: relative;
        }

        body.dark-theme .question-box {
            background: #0d121c;
        }

        .question-box-label {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #c59b27;
            margin-bottom: 4px;
        }

        .question-box-title {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.4;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
            background: #ffffff;
            border: 1.5px solid var(--border-color);
            border-radius: 14px;
            margin-bottom: 20px;
            transition: all 0.2s ease;
        }

        body.dark-theme .input-group-custom {
            background: #0d121c;
        }

        .input-group-custom:focus-within {
            border-color: #c59b27;
            box-shadow: 0 0 0 3px rgba(197, 155, 39, 0.15);
        }

        .form-control-custom {
            border: none !important;
            background: transparent !important;
            height: 48px;
            padding: 0 16px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-main) !important;
            flex: 1;
            outline: none !important;
            box-shadow: none !important;
        }

        .input-btn-append {
            padding: 0 16px;
            color: var(--text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .input-btn-append:hover {
            color: #c59b27;
        }

        .btn-submit {
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

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(197, 155, 39, 0.4);
            background: linear-gradient(135deg, #e9c668 0%, #d4aa33 50%, #aa821c 100%);
        }

        .footer-note {
            margin-top: 16px;
            font-size: 11.5px;
            color: var(--text-muted);
            text-align: center;
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
                <div class="logo-wrap">
                    <div class="logo-fallback-icon">
                        <span class="material-symbols-outlined text-[20px]">account_balance</span>
                    </div>
                    <span class="logo-title">{{ $bankName ?? 'Equitable Bank' }}</span>
                </div>

                <div class="brand-badge">2-Factor Authentication</div>

                <h2>Security Question</h2>
                <p class="subtitle">Please provide the answer to your selected security question to authenticate this session.</p>

                <div class="question-box">
                    <div class="question-box-label">Challenge Question</div>
                    <div class="question-box-title">{{ $question }}</div>
                </div>

                <form role="form" method="POST" action="validate-secret-question">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="question_no" id="question_no" value="{{ $question_no }}" />
                    
                    <div class="input-group-custom">
                        <input type="text" class="form-control-custom" name="answer" id="answer" required value="" placeholder="Type your secret answer here..." autocomplete="off" />
                        <div class="input-btn-append answer" title="Open Virtual Keyboard">
                            <span class="material-symbols-outlined text-[20px]">keyboard</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>Submit & Verify</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>

                    <p class="footer-note">This answer was designated by you during account enrollment.</p>
                </form>
            </div>

            <p style="font-size: 11.5px; color: var(--text-muted); margin-top: 18px; text-align: center;">
                Need help? <a href="{{ url('send-message') }}" style="color: #c59b27; font-weight: 700;">Contact Private Banking Support</a>
            </p>
        </div>

        <!-- Banner Right -->
        <div class="banner-side">
            <div class="banner-overlay"></div>
            
            <div class="relative z-10">
                <div class="banner-badge">
                    <span class="material-symbols-outlined text-[15px]">verified_user</span>
                    Identity Verification
                </div>
            </div>

            <div class="banner-content">
                <h1 class="banner-title">Multi-Layer Guardrails for High-Value Assets.</h1>
                <p class="banner-subtitle">Every session is backed by out-of-band verification and end-to-end cryptographic integrity.</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.keyboard.js') }}"></script>
    <script src="{{ asset('js/jquery.mousewheel.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.9.0/jquery-ui.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#answer').keyboard({
            openOn: null,
            stayOpen: true,
            layout: 'qwerty'
        });

        $('.answer').click(function(){
            var kb = $('#answer').getkeyboard();
            if(kb) kb.reveal();
        });
    });
    </script>
</body>
</html>
