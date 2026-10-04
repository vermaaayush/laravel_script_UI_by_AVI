<?php 
    DB::table('ba_account_holders')->where('user_id',Session::get('user_id'))->update(['login_time' => date('Y-m-d H:i:s')]);  
    $_modules = DB::table('ba_enable_disable_module')->where('id','1')->first(); 
    $confiG = DB::table('configs')->where('id','1')->first();  
    
    if(Session::get('cust_photo') == ""){
        $imgPro = asset('exasset/user.png');
    }else{
        $imgPro = "https://".Session::get('bank_url')."/admin/uploads/".Session::get('cust_photo');
    }
?>

<!-- Main Content Area Wrapper -->
<div class="flex flex-col lg:ml-64 min-h-screen transition-all w-full lg:w-[calc(100%-16rem)] font-sans">
    <!-- TopNavBar (Stitch Sovereign Banking Design) -->
    <header class="sticky top-0 h-16 bg-surface/90 backdrop-blur-xl shadow-[0_1px_6px_rgba(0,0,0,0.03)] z-40 flex justify-between items-center px-4 lg:px-8 border-b border-surface-container-high/60 w-full transition-all duration-200">
        <!-- Left: Mobile Trigger, Mobile Logo & Breadcrumb -->
        <div class="flex items-center gap-3">
            <!-- Mobile Menu Toggle Button -->
            <button onclick="toggleMobileSidebar()" class="lg:hidden shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-secondary hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[22px]">menu</span>
            </button>

            <!-- Mobile Brand Logo -->
            <a href="{{ url('/') }}" class="lg:hidden flex items-center">
                <?php if(!empty($confiG->logo)){ ?>
                    <img src="/admin/uploads/{{ $confiG->logo }}" alt="{{ $confiG->bank_name ?? 'Bank' }}" class="h-9 w-auto max-w-[150px] object-contain">
                <?php } ?>
            </a>

            <!-- Breadcrumbs Navigation -->
            <div class="hidden sm:flex items-center gap-2 text-xs font-medium text-[#53625b]">
                <a href="{{ url('/') }}" class="hover:text-[#004226] transition-colors">Portal</a>
                <span>/</span>
                <span class="text-[#191c1c] font-bold capitalize">{{ !empty($page) ? str_replace(['-', '_'], ' ', $page) : ($main ?? 'Dashboard') }}</span>
            </div>
        </div>

        <!-- Right Side: Session Timer, Quick Actions, Notifications & Profile -->
        <div class="flex items-center gap-2 sm:gap-3">
            <!-- Google Translate Integration -->
            <div id="google_translate_element" class="hidden 2xl:block relative z-50"></div>
            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        IncludedLanguage: 'es,fr,de,it,pt,zh-CN',
                        autoDisplay: false
                    }, 'google_translate_element');
                }
            </script>
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            <style>
                .goog-te-combo { 
                    padding: 2px 8px !important; 
                    font-size: 11px !important; 
                    border-radius: 9999px !important; 
                    border: 1px solid #e6e9e8 !important; 
                    color: #191c1c !important; 
                    background-color: #ffffff !important; 
                    height: 28px !important; 
                    margin: 0 !important; 
                    outline: none !important;
                }
                .goog-te-gadget { font-size: 0px !important; color: transparent !important; }
                .goog-te-gadget > span { display: none !important; }
                .goog-logo-link { display: none !important; }
                .goog-te-banner-frame.skiptranslate { display: none !important; }
                .skiptranslate iframe { display: none !important; }
                body { top: 0px !important; }
            </style>

            <!-- Session Countdown Timer (Security Critical) -->
            <div class="hidden lg:flex items-center gap-1.5 bg-[#f8faf9] border border-[#e6e9e8] rounded-full px-3 py-1 shadow-2xs" title="Security Session Timeout">
                <span class="material-symbols-outlined text-[15px] text-[#004226]">lock_clock</span>
                <span id="countdown" class="text-xs font-mono font-bold text-[#191c1c]"></span>
                <input type="hidden" id="logout_time" value="{{ $confiG->logout_time ?? 15 }}">
            </div>

            <!-- Quick Transfer CTA (Stitch Reference Header Button) -->
            <a href="{{ url('transfer-to-other-bank') }}" class="hidden sm:inline-flex items-center gap-1.5 bg-[#004226] text-white font-bold text-xs px-4 py-2 rounded-full shadow-xs hover:bg-[#0f5b38] transition-colors">
                <span class="material-symbols-outlined text-[16px]">send_money</span>
                <span>Quick Transfer</span>
            </a>

            <!-- Messages Link -->
            <a href="{{ url('all-messages') }}" class="p-2 text-secondary hover:text-on-surface hover:bg-surface-container rounded-full transition-colors hidden sm:block" title="Messages">
                <span class="material-symbols-outlined text-[20px]">mail</span>
            </a>

            <!-- Notifications Toggle (Stitch Style) -->
            <div class="relative">
                <button onclick="toggleTopNav('notifications-dropdown')" class="relative p-2 text-secondary hover:text-on-surface hover:bg-surface-container rounded-full transition-colors" title="Notifications">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-primary ring-2 ring-surface"></span>
                </button>

                <!-- Notifications Dropdown -->
                <div id="notifications-dropdown" class="hidden absolute top-12 right-0 w-[340px] bg-surface-container-lowest shadow-xl rounded-2xl border border-outline-variant/40 overflow-hidden z-50 transition-all duration-200 origin-top-right">
                    <div class="p-4 border-b border-surface-container-high/60 flex items-center justify-between bg-surface-container-low/50">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-on-surface">Notifications</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-fixed text-on-primary-fixed">Alerts</span>
                        </div>
                        <a href="{{ asset('all-messages') }}" class="text-[11px] text-primary font-semibold hover:underline">View all</a>
                    </div>
                    <div class="max-h-[300px] overflow-y-auto divide-y divide-surface-container-high/50">
                        <?php $noti = DB::table('notifications')->where('customer',Session::get('id'))->orderBy('id', 'desc')->limit(5); ?>
                        <?php if($noti->count() > 0){ ?>
                            @foreach($noti->get() as $row)
                                <?php $msg = DB::table('msg')->where('id',$row->msg_id)->first(); ?>         
                                <div class="flex gap-3 p-3.5 hover:bg-surface-container-low transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center shrink-0 text-primary">
                                        <span class="material-symbols-outlined text-[17px]">mail</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-on-surface line-clamp-2 leading-snug">{{ $msg->msg ?? 'Notification received' }}</p>
                                        <div class="flex items-center gap-1.5 text-[10.5px] text-secondary mt-1">
                                            <span>{{ $msg->sender ?? 'System' }}</span>
                                            <span>•</span>
                                            <span>{{ $msg->date ?? date('d M') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        <?php } else { ?>
                            <div class="p-6 flex flex-col items-center justify-center text-center">
                                <div class="w-10 h-10 bg-surface-container-low rounded-full flex items-center justify-center mb-2 text-secondary">
                                    <span class="material-symbols-outlined text-[20px]">notifications_none</span>
                                </div>
                                <p class="text-xs font-semibold text-on-surface">All caught up!</p>
                                <p class="text-[11px] text-secondary">No new alerts at this time.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Profile Info & Dropdown -->
            <div class="relative">
                <div onclick="toggleTopNav('profile-dropdown')" class="flex items-center gap-2 pl-2 pr-1 py-1 rounded-full hover:bg-surface-container cursor-pointer transition-colors">
                    <img alt="Profile" class="w-8 h-8 rounded-full object-cover ring-2 ring-surface-container-high" src="{{ $imgPro }}">
                    <div class="hidden md:flex flex-col text-left leading-none">
                        <span class="text-xs font-semibold text-on-surface">{{ Session::get('cust_name') ?? 'Client' }}</span>
                        <span class="text-[10px] text-secondary">Sovereign Account</span>
                    </div>
                    <span class="material-symbols-outlined text-secondary text-[16px]">keyboard_arrow_down</span>
                </div>

                <!-- Profile Dropdown -->
                <div id="profile-dropdown" class="hidden absolute top-12 right-0 w-[240px] bg-surface-container-lowest shadow-xl rounded-2xl border border-outline-variant/40 overflow-hidden z-50 transition-all duration-200 origin-top-right">
                    <div class="p-3.5 border-b border-surface-container-high/60 bg-surface-container-low/50 flex items-center gap-2.5">
                        <img alt="Profile" class="w-9 h-9 rounded-full object-cover ring-1 ring-surface-container-high" src="{{ $imgPro }}">
                        <div class="min-w-0">
                            <h5 class="text-xs font-bold text-on-surface truncate">{{ Session::get('cust_name') }}</h5>
                            <p class="text-[10px] text-secondary font-mono truncate">{{ Session::get('login_ip') }}</p>
                        </div>
                    </div>
                    
                    <div class="py-1 text-xs">
                        <a href="{{ asset('viewProfile') }}" class="flex items-center gap-2 px-4 py-2 text-on-surface hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-secondary">person</span>
                            <span>My Profile</span>
                        </a>
                        <a href="{{ asset('editProfile') }}" class="flex items-center gap-2 px-4 py-2 text-on-surface hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-secondary">manage_accounts</span>
                            <span>Account Details</span>
                        </a>
                        <a href="{{ asset('password-update') }}" class="flex items-center gap-2 px-4 py-2 text-on-surface hover:bg-surface-container-low transition-colors">
                            <span class="material-symbols-outlined text-[17px] text-secondary">lock_reset</span>
                            <span>Security & PIN</span>
                        </a>
                    </div>
                    
                    <div class="p-2 border-t border-surface-container-high/60 bg-surface-container-low/40">
                        <a href="{{ asset('logout-user') }}" class="flex items-center justify-center gap-1.5 w-full py-1.5 bg-error-container/60 hover:bg-error-container text-error rounded-xl text-xs font-semibold transition-colors">
                            <span class="material-symbols-outlined text-[16px]">logout</span>
                            <span>Sign Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

<!-- Global Content Workspace Wrapper -->
<main class="w-full flex-1 p-4 lg:p-7 pb-16 overflow-y-auto bg-background">

<script type="text/javascript">
    function toggleMobileSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (!sidebar) return;
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            if(overlay) overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            if(overlay) overlay.classList.add('hidden');
        }
    }

    function toggleTopNav(id) {
        const el = document.getElementById(id);
        const dropdowns = ['notifications-dropdown', 'profile-dropdown'];
        dropdowns.forEach(d => {
            if (d !== id) {
                const other = document.getElementById(d);
                if (other) other.classList.add('hidden');
            }
        });
        if (el) el.classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        const notiBtn = document.getElementById('notifications-dropdown');
        const profBtn = document.getElementById('profile-dropdown');
        if (notiBtn && !e.target.closest('#notifications-dropdown') && !e.target.closest('[onclick*="notifications-dropdown"]')) {
            notiBtn.classList.add('hidden');
        }
        if (profBtn && !e.target.closest('#profile-dropdown') && !e.target.closest('[onclick*="profile-dropdown"]')) {
            profBtn.classList.add('hidden');
        }
    });

    // Session Countdown Logic (Preserved)
    document.addEventListener("DOMContentLoaded", function () {
        var timerElement = document.getElementById("countdown");
        if (!timerElement) return;

        var logoutTimeMinutes = parseInt(document.getElementById("logout_time").value) || 15;
        var totalTime = logoutTimeMinutes * 60;

        function updateCountdown() {
            var minutes = Math.floor(totalTime / 60);
            var seconds = totalTime % 60;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            timerElement.textContent = minutes + ":" + seconds;
            if (totalTime <= 0) {
                clearInterval(countdownInterval);
                window.location.href = "{{ url('logout-user') }}";
            }
            totalTime--;
        }

        updateCountdown();
        var countdownInterval = setInterval(updateCountdown, 1000);
    });
</script>
