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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Virtual Keyboard Assets (Retained) -->
    <link href="https://code.jquery.com/ui/1.9.0/themes/ui-darkness/jquery-ui.css" rel="stylesheet">
    <link href="{{ asset('css/keyboard.css') }}" rel="stylesheet">

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
        .ui-widget-content {
            border: 1px solid #bfc9bf;
            background: #ffffff !important;
            color: #191c1c;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
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
                    Multi-tier guardrails for high-value asset protection.
                </h1>
                <p class="text-white/80 text-sm leading-relaxed">
                    Every institutional session requires confidential challenge verification designated at account onboarding to prevent unauthorized custody traversal.
                </p>
            </div>

            <!-- Bottom Compliance Footer -->
            <div class="relative z-10 flex items-center justify-between text-white/70 text-xs font-medium pt-4 border-t border-white/10">
                <span>{{ $activeBankName }}</span>
                <span class="text-[11px] tracking-wider uppercase opacity-80 font-mono">Security Question</span>
            </div>
        </div>

        <!-- Right Column: Verification Form Interface (50%) -->
        <div class="w-full lg:w-1/2 h-full flex flex-col justify-center items-center p-6 sm:p-10 lg:p-16 bg-white overflow-hidden">
            <div class="w-full max-w-md mx-auto my-auto">
                <div class="mb-5">
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-on-surface tracking-tight mb-1.5">
                        Security Question
                    </h2>
                    <p class="text-xs sm:text-sm text-secondary">
                        Please provide the verified answer to your registered challenge question.
                    </p>
                </div>

                <!-- Challenge Question Highlight Card -->
                <div class="mb-5 p-4 rounded-2xl bg-surface-container-low border border-primary/20 relative overflow-hidden">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0 mt-0.5">
                            <span class="material-symbols-outlined text-[18px]">help_center</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-primary block mb-0.5">
                                Designated Question #{{ $question_no ?? '1' }}
                            </span>
                            <div class="font-heading font-bold text-sm sm:text-base text-on-surface leading-snug">
                                {{ $question }}
                            </div>
                        </div>
                    </div>
                </div>

                <form role="form" method="POST" action="validate-secret-question" class="space-y-4">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="question_no" id="question_no" value="{{ $question_no }}" />

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="answer" class="block text-xs font-semibold uppercase tracking-wider text-secondary">
                                Secret Answer <span class="text-error">*</span>
                            </label>
                            <button type="button" class="answer text-xs text-primary hover:text-primary-container font-semibold flex items-center gap-1 transition-colors">
                                <span class="material-symbols-outlined text-[15px]">keyboard</span>
                                <span>Virtual Keyboard</span>
                            </button>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-outline">
                                <span class="material-symbols-outlined text-[18px]">key</span>
                            </span>
                            <input type="text" 
                                   id="answer" 
                                   name="answer" 
                                   required 
                                   value="" 
                                   autocomplete="off"
                                   autofocus
                                   placeholder="Type your secret answer here..." 
                                   class="w-full pl-11 pr-11 py-2.5 rounded-xl border border-outline-variant/60 bg-surface-container-low/40 text-on-surface font-medium text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-outline" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer answer text-outline hover:text-primary transition-colors" title="Open Virtual Keyboard">
                                <span class="material-symbols-outlined text-[18px]">keyboard</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full py-3.5 px-6 rounded-full bg-primary hover:bg-primary-container text-on-primary font-heading font-bold text-xs sm:text-sm tracking-wide shadow-md flex items-center justify-center gap-2 transition-all">
                        <span>Validate & Access Account</span>
                        <span class="material-symbols-outlined text-[17px]">verified</span>
                    </button>
                </form>

                <div class="mt-4 pt-3 border-t border-surface-container flex items-center justify-between text-xs text-secondary">
                    <a href="{{ url('login') }}" class="hover:text-primary font-semibold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                        <span>Back to Login</span>
                    </a>
                    <span>Protected by 256-Bit TLS</span>
                </div>
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
