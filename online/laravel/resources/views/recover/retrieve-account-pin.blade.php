<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $bankName ?? 'First Lake Bank' }} - Retrieve Account PIN</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    
    <!-- Design System Scripts & Fonts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
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
                    },
                    secondary: {
                        DEFAULT: "#53625b",
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
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        body, input, button, select {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
    </style>
</head>
<body class="bg-white font-sans text-[#191c1c] antialiased h-screen w-screen overflow-hidden m-0 p-0 select-none">

    <?php
        $confiG = DB::table('configs')->where('id', '1')->first();
        $activeLogo = !empty($logo) ? $logo : ($confiG->logo ?? '');
        $activeBankName = $bankName ?? ($confiG->bank_name ?? 'First Lake Bank');
    ?>

    <!-- Full Screen Split Layout: Left Green Area (50%) + Right Form Area (50%) -->
    <div class="w-full h-full flex flex-col lg:flex-row overflow-hidden m-0 p-0">
        
        <!-- Left Column: Rich Sovereign Green Brand Area (50%) -->
        <div class="relative w-full lg:w-1/2 h-full flex flex-col justify-between p-8 sm:p-12 lg:p-14 overflow-hidden bg-gradient-to-br from-[#001f12] via-[#003820] to-[#014427] text-white select-none">
            <!-- Architectural Background Texture with High-Definition Duotone -->
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 ease-out hover:scale-105 pointer-events-none" 
                 style="background-image: url('{{ asset('images/auth_luxury_banner.jpg') }}'); opacity: 0.22; mix-blend-mode: luminosity;"></div>
            
            <!-- Multi-layered Ambient Emerald & Mint Lighting -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#00180d]/95 via-[#00321c]/75 to-[#002716]/65 pointer-events-none"></div>
            <div class="absolute -top-32 -left-20 w-[520px] h-[520px] rounded-full bg-emerald-400/15 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-10 right-0 w-[460px] h-[460px] rounded-full bg-teal-500/10 blur-[100px] pointer-events-none"></div>
            
            <!-- Subtle Institutional Watermark Grid -->
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 24px 24px;"></div>

            <!-- Top Header: Logo & Security Badge -->
            <div class="relative z-10 flex items-center justify-between gap-4">
                <a href="{{ url('/') }}" class="inline-flex items-center">
                    <?php if(!empty($activeLogo)){ ?>
                        <div class="px-4 py-2 rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.22)] inline-flex items-center border border-white/80 transition-transform hover:scale-[1.02]">
                            <img src="/admin/uploads/{{ $activeLogo }}" alt="{{ $activeBankName }}" class="h-9 sm:h-11 w-auto max-w-[210px] object-contain">
                        </div>
                    <?php } else { ?>
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white shadow-sm border border-white/20">
                                <span class="material-symbols-outlined text-[26px]">account_balance</span>
                            </div>
                            <span class="font-heading font-extrabold text-2xl tracking-tight text-white block">{{ $activeBankName }}</span>
                        </div>
                    <?php } ?>
                </a>

                <!-- Clean Online Banking Status Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-[#aaf2c4] border border-white/15 text-xs font-medium shadow-sm">
                    <span class="inline-block w-2 h-2 rounded-full bg-[#6bff8f]"></span>
                    <span>Secure Online Banking</span>
                </div>
            </div>

            <!-- Center Content: Simple & Direct Online Banking Copy -->
            <div class="relative z-10 my-auto py-4 max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-[#aaf2c4] mb-3 text-xs font-semibold uppercase tracking-wider border border-white/15">
                    <span class="material-symbols-outlined text-[15px]">pin</span>
                    <span>Credential Service</span>
                </div>

                <h1 class="font-heading font-bold text-3xl sm:text-4xl lg:text-[42px] text-white tracking-tight leading-[1.2] mb-3">
                    Forgot your PIN? <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#aaf2c4] via-[#6bff8f] to-white">Reset it securely online.</span>
                </h1>

                <p class="text-sm sm:text-base text-white/80 font-normal leading-relaxed max-w-lg mb-6">
                    Verify your identity and securely reset your account security PIN anytime.
                </p>

                <!-- 3 Simple Online Banking Pillars -->
                <div class="grid grid-cols-3 gap-3 pt-5 border-t border-white/15">
                    <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <span class="material-symbols-outlined text-[#aaf2c4] text-[20px]">lock</span>
                        <div>
                            <p class="text-xs font-bold text-white leading-tight">256-Bit</p>
                            <p class="text-[10px] text-white/70 leading-tight">Security</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <span class="material-symbols-outlined text-[#aaf2c4] text-[20px]">encrypted</span>
                        <div>
                            <p class="text-xs font-bold text-white leading-tight">Instant</p>
                            <p class="text-[10px] text-white/70 leading-tight">Reset</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                        <span class="material-symbols-outlined text-[#aaf2c4] text-[20px]">support_agent</span>
                        <div>
                            <p class="text-xs font-bold text-white leading-tight">24/7</p>
                            <p class="text-[10px] text-white/70 leading-tight">Support</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Footnote -->
            <div class="relative z-10 flex items-center justify-between text-white/70 text-xs font-medium pt-3 border-t border-white/10">
                <span>Safe & Encrypted Connection</span>
                <span class="text-[11px] font-medium opacity-80">{{ $activeBankName }}</span>
            </div>
        </div>

        <!-- Right Column: Clean White Form Area (50%) -->
        <div class="w-full lg:w-1/2 h-full flex flex-col justify-center items-center px-6 sm:px-12 lg:px-16 py-6 bg-white overflow-y-auto no-scrollbar">
            <div class="w-full max-w-[390px] mx-auto flex flex-col justify-center">
                <!-- Header Text -->
                <div class="mb-5">
                    <h2 class="font-heading font-extrabold text-2xl sm:text-[26px] text-[#191c1c] tracking-tight leading-tight mb-1">
                        Retrieve Account PIN
                    </h2>
                    <p class="text-xs sm:text-[13px] text-[#53625b] leading-relaxed">
                        Enter your registered User ID to initiate secure PIN validation.
                    </p>
                </div>

                @include('flash::message')

                <!-- Recovery Form -->
                <form id="form-wizard1" method="POST" action="retrieve-account-pin" class="flex flex-col gap-4">
                    @csrf

                    @if(isset($otp) && $otp == 'show2')
                    <!-- Step 3: Set New PIN -->
                    <div class="flex flex-col gap-3.5">
                        <div class="flex flex-col gap-1">
                            <label class="text-[12px] text-[#191c1c] font-semibold">New Account PIN</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-[#53625b] text-[18px] pointer-events-none">pin</span>
                                <input type="password" name="pin1" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pin1" class="w-full pl-10 pr-4 py-2.5 bg-[#f8faf9] text-[#191c1c] placeholder:text-[#53625b]/60 text-xs sm:text-sm rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#004226]/15 focus:border-[#004226] border border-[#e6e9e8] transition-all font-sans" placeholder="••••" maxlength="6" value='{{ $pin1 ?? '' }}' required>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-[12px] text-[#191c1c] font-semibold">Confirm Account PIN</label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-[#53625b] text-[18px] pointer-events-none">lock</span>
                                <input type="password" name="pin2" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="pin2" class="w-full pl-10 pr-4 py-2.5 bg-[#f8faf9] text-[#191c1c] placeholder:text-[#53625b]/60 text-xs sm:text-sm rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#004226]/15 focus:border-[#004226] border border-[#e6e9e8] transition-all font-sans" placeholder="••••" maxlength="6" value='{{ $pin2 ?? '' }}' required>
                            </div>
                        </div>

                        <button type="submit" name="submit" id="pinsequal" value="submitpin" class="w-full py-3 px-6 rounded-xl bg-[#004226] hover:bg-[#085232] text-white font-heading font-semibold text-sm shadow-[0_4px_14px_rgba(0,66,38,0.25)] hover:shadow-[0_6px_20px_rgba(0,66,38,0.32)] transition-all flex items-center justify-center gap-2 group cursor-pointer mt-1" style="display: none;">
                            <span>Confirm & Set PIN</span>
                            <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-0.5">arrow_forward</span>
                        </button>

                        <script>
                            setInterval(function() {
                                var pin1 = document.querySelector("#pin1") ? document.querySelector("#pin1").value : "";
                                var pin2 = document.querySelector("#pin2") ? document.querySelector("#pin2").value : "";
                                if(pin1 === pin2 && pin1.length > 0){
                                    document.querySelector('#pinsequal').style.display = 'flex';
                                } else {
                                    document.querySelector('#pinsequal').style.display = 'none';
                                }
                            }, 200);
                        </script>
                    </div>
                    @endif

                    @if(isset($otp) && ($otp == 'show' || $otp == 'show2'))
                    <!-- Step 2: One-Time Password -->
                    <div class="flex flex-col gap-3.5 mt-1">
                        <div class="flex flex-col gap-1">
                            <label class="text-[12px] text-[#191c1c] font-semibold">Enter Email Security OTP</label>
                            <input type="text" class="w-full px-4 py-2.5 bg-[#f8faf9] text-[#004226] placeholder:text-[#53625b]/60 font-mono font-bold tracking-[0.25em] text-center text-base rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#004226]/15 focus:border-[#004226] border border-[#e6e9e8] transition-all" id="otpcode" name="otp" placeholder="000000" value="@if($otp == 'show2'){{ $otprequired ?? '' }}@endif" required>
                        </div>

                        <button type="submit" name="submit" id="otpsequal" value="submitotp" class="w-full py-3 px-6 rounded-xl bg-[#004226] hover:bg-[#085232] text-white font-heading font-semibold text-sm shadow-[0_4px_14px_rgba(0,66,38,0.25)] hover:shadow-[0_6px_20px_rgba(0,66,38,0.32)] transition-all flex items-center justify-center gap-2 group cursor-pointer mt-1">
                            <span>Verify Code</span>
                            <span class="material-symbols-outlined text-[18px]">key</span>
                        </button>
                    </div>
                    @endif

                    @if(!isset($otp) || ($otp != 'show' && $otp != 'show2'))
                    <!-- Step 1: User ID -->
                    <div class="flex flex-col gap-3.5">
                        <div class="flex flex-col gap-1">
                            <label class="text-[12px] text-[#191c1c] font-semibold" for="validationCustom06">
                                Account User ID
                            </label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-[#53625b] text-[18px] pointer-events-none">person</span>
                                <input type="text" name="user" class="w-full pl-10 pr-4 py-2.5 bg-[#f8faf9] text-[#191c1c] placeholder:text-[#53625b]/60 text-xs sm:text-sm rounded-xl focus:outline-none focus:bg-white focus:ring-2 focus:ring-[#004226]/15 focus:border-[#004226] border border-[#e6e9e8] transition-all font-sans" 
                                       id="validationCustom06" placeholder="Enter your banking User ID" value='{{ $user ?? '' }}' required autocomplete="username"/>
                            </div>
                        </div>

                        <button type="submit" name="submit" value="Next" class="w-full py-3 px-6 rounded-xl bg-[#004226] hover:bg-[#085232] text-white font-heading font-semibold text-sm shadow-[0_4px_14px_rgba(0,66,38,0.25)] hover:shadow-[0_6px_20px_rgba(0,66,38,0.32)] transition-all flex items-center justify-center gap-2 group cursor-pointer mt-1">
                            <span>Proceed to Verification</span>
                            <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-0.5">arrow_forward</span>
                        </button>
                    </div>
                    @endif
                </form>

                <!-- Self-Service Navigation Hub -->
                <div class="mt-6 pt-4 border-t border-[#eef1f0] flex flex-col gap-2">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#53625b] text-center block mb-1">Self-Service Options</span>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <a href="{{ url('login') }}" class="py-2 px-3 rounded-xl bg-[#f8faf9] hover:bg-[#eaf4ee] text-[#004226] font-semibold border border-[#e6e9e8] flex items-center justify-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">login</span>
                            <span>Sign In</span>
                        </a>
                        <a href="{{ url('online-open-account') }}" class="py-2 px-3 rounded-xl bg-[#f8faf9] hover:bg-[#eaf4ee] text-[#004226] font-semibold border border-[#e6e9e8] flex items-center justify-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">add_circle</span>
                            <span>Open Account</span>
                        </a>
                    </div>
                    <a href="{{ url('retrieve-account-user-id') }}" class="py-2 px-3 rounded-xl bg-[#f8faf9] hover:bg-[#eaf4ee] text-[#004226] font-semibold border border-[#e6e9e8] flex items-center justify-center gap-1.5 text-xs transition-colors">
                        <span class="material-symbols-outlined text-[16px]">person_search</span>
                        <span>Forgot User ID? Retrieve Online</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        jQuery('div.alert').not('.alert-important').delay(8000).fadeOut(1000);
    </script>
</body>
</html>
