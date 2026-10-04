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
    <title>{{ $bankName ?? 'OripioFin' }} - Security Verification</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    
    <!-- Design System Scripts & Fonts (Stitch Sovereign Banking Design) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    primary: {
                        DEFAULT: "#004226",
                        container: "#0f5b38",
                        fixed: "#aaf2c4",
                        "fixed-dim": "#8fd6a9",
                        dark: "#00301b",
                    },
                    "on-primary": "#ffffff",
                    "on-primary-container": "#8ad1a4",
                    secondary: {
                        DEFAULT: "#53625b",
                        container: "#d3e3db",
                    },
                    "on-secondary": "#ffffff",
                    tertiary: {
                        DEFAULT: "#004219",
                        container: "#005c26",
                        fixed: "#6bff8f",
                    },
                    surface: {
                        DEFAULT: "#f8faf9",
                        container: {
                            lowest: "#ffffff",
                            low: "#f2f4f3",
                            DEFAULT: "#eceeed",
                            high: "#e6e9e8",
                            highest: "#e1e3e2",
                        }
                    },
                    "on-surface": "#191c1c",
                    "on-surface-variant": "#404942",
                    background: "#f8faf9",
                    outline: {
                        DEFAULT: "#707971",
                        variant: "#bfc9bf",
                    },
                    error: {
                        DEFAULT: "#ba1a1a",
                        container: "#ffdad6",
                    }
                },
                fontFamily: {
                    sans: ["'Inter'", "sans-serif"],
                    heading: ["'Plus Jakarta Sans'", "sans-serif"],
                    mono: ["'JetBrains Mono'", "monospace"],
                }
            }
        }
    }
    </script>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
            line-height: 1;
        }
        @keyframes shakeAnim {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .shake-error {
            animation: shakeAnim 0.4s ease-in-out;
            border-color: #ba1a1a !important;
        }
    </style>
</head>
<body class="bg-white font-sans text-on-surface antialiased h-screen w-screen overflow-hidden m-0 p-0 select-none">

    <?php
        $confiG = DB::table('configs')->where('id', '1')->first();
        $activeLogo = !empty($logo) ? $logo : ($confiG->logo ?? '');
        $activeBankName = $bankName ?? ($confiG->bank_name ?? 'First Lake Bank');
    ?>

    <!-- Full Screen Split Layout: Left Green Area (50%) + Right Form Area (50%) -->
    <div class="w-full h-full flex flex-col lg:flex-row overflow-hidden m-0 p-0">
        
        <!-- Left Column: Rich Sovereign Green Brand Area (50%) -->
        <div class="relative w-full lg:w-1/2 h-full flex flex-col justify-between p-8 sm:p-12 lg:p-16 overflow-hidden bg-[#004226] text-white">
            <!-- Architectural Background Texture -->
            <div class="absolute inset-0 bg-cover bg-center mix-blend-overlay opacity-30 transition-transform duration-1000 ease-out hover:scale-105 pointer-events-none" 
                 style="background-image: url('{{ asset('images/auth_luxury_banner.jpg') }}');"></div>
            <!-- Sovereign Emerald Atmosphere Gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#002816] via-[#004226]/90 to-[#0a4d2e]/85 pointer-events-none"></div>
            <!-- Ambient Decorative Glow -->
            <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-emerald-400/10 blur-3xl pointer-events-none"></div>

            <!-- Top Header in Left Canvas: Logo -->
            <div class="relative z-10 flex items-center">
                <a href="{{ url('/') }}" class="inline-flex items-center">
                    <?php if(!empty($activeLogo)){ ?>
                        <div class="px-4 py-2 rounded-2xl bg-white shadow-lg inline-flex items-center">
                            <img src="/admin/uploads/{{ $activeLogo }}" alt="{{ $activeBankName }}" class="h-10 sm:h-12 w-auto max-w-[220px] object-contain">
                        </div>
                    <?php } else { ?>
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white shadow-sm">
                                <span class="material-symbols-outlined text-[26px]">account_balance</span>
                            </div>
                            <span class="font-heading font-extrabold text-2xl tracking-tight text-white block">{{ $activeBankName }}</span>
                        </div>
                    <?php } ?>
                </a>
            </div>

            <!-- Center Content -->
            <div class="relative z-10 my-auto py-8 max-w-xl">
                <h1 class="font-heading font-bold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight drop-shadow-sm mb-3">
                    Multi-factor attestation for institutional operations.
                </h1>
                <p class="text-white/80 text-sm leading-relaxed">
                    To safeguard high-volume settlement pipelines and treasury accounts, please confirm the cryptographic challenge token displayed before continuing.
                </p>
            </div>

            <!-- Bottom Compliance Footer -->
            <div class="relative z-10 flex items-center justify-between text-white/70 text-xs font-medium pt-4 border-t border-white/10">
                <span>{{ $activeBankName }}</span>
                <span class="text-[11px] tracking-wider uppercase opacity-80 font-mono">Security Checkpoint</span>
            </div>
        </div>

        <!-- Right Column: Verification Form Interface (50%) -->
        <div class="w-full lg:w-1/2 h-full flex flex-col justify-center items-center p-6 sm:p-10 lg:p-16 bg-white overflow-hidden">
            <div class="w-full max-w-md mx-auto my-auto">
                <div class="mb-6">
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-on-surface tracking-tight mb-1.5">
                        Security Checkpoint
                    </h2>
                    <p class="text-xs sm:text-sm text-secondary">
                        Enter the 5-character authorization code generated below to proceed with your banking session.
                    </p>
                </div>

                <!-- Interactive Captcha Box -->
                <div class="mb-5 p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between gap-4">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-secondary block mb-0.5">Session Code</span>
                        <div class="captcha-code-text font-mono text-2xl sm:text-3xl font-extrabold tracking-[0.3em] text-primary select-none" id="captcha">
                            <?= $captchaCode ?>
                        </div>
                    </div>
                    <button type="button" id="refreshBtn" title="Generate New Session Code" 
                            class="w-10 h-10 rounded-xl bg-white hover:bg-surface-container border border-outline-variant/30 flex items-center justify-center text-primary shadow-sm hover:rotate-180 transition-all duration-300">
                        <span class="material-symbols-outlined text-[18px]">refresh</span>
                    </button>
                </div>

                <form id="captchaForm" action="{{ url('captcha') }}" method="GET" onsubmit="return validateForm(event);" class="space-y-4">
                    <div>
                        <label for="enteredCaptcha" class="block text-xs font-semibold uppercase tracking-wider text-secondary mb-1.5">
                            Authorization Token <span class="text-error">*</span>
                        </label>
                        <div class="relative" id="inputWrap">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-outline">
                                <span class="material-symbols-outlined text-[18px]">key</span>
                            </span>
                            <input type="text" 
                                   id="enteredCaptcha" 
                                   name="enteredCaptcha" 
                                   required 
                                   autocomplete="off"
                                   autofocus
                                   placeholder="Enter 5-character code above" 
                                   class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-outline-variant/60 bg-surface-container-low/40 text-on-surface font-mono font-bold tracking-widest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder:font-sans placeholder:font-normal placeholder:tracking-normal placeholder:text-outline" />
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full py-3.5 px-6 rounded-full bg-primary hover:bg-primary-container text-on-primary font-heading font-bold text-xs sm:text-sm tracking-wide shadow-md flex items-center justify-center gap-2 transition-all">
                        <span>Authorize & Enter Portal</span>
                        <span class="material-symbols-outlined text-[17px]">verified</span>
                    </button>
                </form>

                <div class="mt-4 pt-3 border-t border-surface-container flex items-center justify-center text-xs text-secondary">
                    <span>Protected by 256-Bit TLS Encryption</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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
            $('#enteredCaptcha').val('').focus();
            $('#inputWrap input').removeClass('shake-error');
        });

        function validateForm(e) {
            var currentCaptcha = $('#captcha').text().trim().toUpperCase();
            var entered = $('#enteredCaptcha').val().trim().toUpperCase();

            if (entered !== currentCaptcha) {
                e.preventDefault();
                $('#inputWrap input').addClass('shake-error');
                setTimeout(function() {
                    $('#inputWrap input').removeClass('shake-error');
                }, 500);
                alert('Invalid security verification token. Please try again.');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
