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
<div class="flex flex-col lg:ml-[265px] min-h-screen transition-all w-full lg:w-[calc(100%-265px)]">
    <!-- TopNavBar -->
    <header class="sticky top-0 h-[68px] glass-header flex justify-between items-center px-4 lg:px-8 z-30 border-b border-[#edf0f4] w-full transition-all duration-200">
        <!-- Search & Mobile Menu Trigger -->
        <div class="flex-1 max-w-xl flex items-center gap-3">
            <!-- Mobile Menu Toggle Button -->
            <button onclick="toggleMobileSidebar()" class="lg:hidden shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-slate-600 hover:bg-slate-100 transition-colors">
                <span class="material-symbols-outlined text-[22px]">menu</span>
            </button>

            <!-- Search Bar (Reference Design) -->
            <div class="hidden sm:flex relative items-center w-full h-10 rounded-xl bg-slate-50 border border-slate-200/80 focus-within:border-slate-800 focus-within:bg-white focus-within:ring-2 focus-within:ring-slate-900/5 transition-all overflow-hidden">
                <div class="grid place-items-center h-full w-10 text-slate-400">
                    <span class="material-symbols-outlined text-[19px]">search</span>
                </div>
                <input class="peer h-full w-full outline-none text-[13px] font-sans text-slate-800 bg-transparent border-0 focus:ring-0 pr-4 placeholder:text-slate-400" id="search" placeholder="Search transactions, accounts, beneficiaries..." type="text">
            </div>

            <!-- Google Translate Integration -->
            <div id="google_translate_element" class="hidden xl:block ml-1 relative z-50"></div>
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
                    padding: 3px 8px !important; 
                    font-size: 11.5px !important; 
                    border-radius: 6px !important; 
                    border: 1px solid #e2e8f0 !important; 
                    color: #1e293b !important; 
                    background-color: #f8fafc !important; 
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
        </div>

        <!-- Right Side: Clock, Session Timer, Notifications & Profile -->
        <div class="flex items-center gap-2.5 sm:gap-4 ml-3 relative">
            <!-- Live Date & Clock (From Reference Header) -->
            <div class="hidden 2xl:flex flex-col items-end text-right">
                <span id="live-date-header" class="text-[11px] font-medium text-slate-500 tracking-tight"></span>
                <span id="live-time-header" class="text-[12px] font-bold text-slate-800 font-mono tracking-wide"></span>
            </div>

            <script>
                function updateLiveHeaderClock() {
                    const now = new Date();
                    const optionsDate = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric' };
                    const dateStr = now.toLocaleDateString('en-GB', optionsDate);
                    const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
                    const dateEl = document.getElementById('live-date-header');
                    const timeEl = document.getElementById('live-time-header');
                    if(dateEl) dateEl.innerText = dateStr;
                    if(timeEl) timeEl.innerText = timeStr;
                }
                updateLiveHeaderClock();
                setInterval(updateLiveHeaderClock, 30000);
            </script>

            <!-- Session Countdown Timer -->
            <div class="hidden md:flex items-center gap-1.5 bg-amber-50 border border-amber-200/80 rounded-full px-3 py-1" title="Security Session Timeout">
                <span class="material-symbols-outlined text-[15px] text-amber-600 animate-pulse">lock_clock</span>
                <span id="countdown" class="text-[12px] font-bold text-amber-800 font-mono"></span>
                <input type="hidden" id="logout_time" value="{{ $confiG->logout_time ?? 15 }}">
            </div>

            <!-- Notifications Toggle -->
            <div class="relative">
                <button onclick="toggleTopNav('notifications-dropdown')" class="relative w-9 h-9 rounded-xl border border-slate-200/70 bg-white flex items-center justify-center text-slate-600 hover:text-slate-900 hover:border-slate-300 transition-colors shadow-2xs">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                </button>

                <!-- Notifications Dropdown -->
                <div id="notifications-dropdown" class="hidden absolute top-[50px] right-0 w-[340px] bg-white shadow-xl rounded-2xl border border-slate-100 overflow-hidden z-50 transition-all duration-200 origin-top-right">
                    <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-slate-900">Notifications</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Alerts</span>
                        </div>
                        <a href="{{ asset('all-messages') }}" class="text-[11px] text-[#c59b27] font-semibold hover:underline">View all</a>
                    </div>
                    <div class="max-h-[320px] overflow-y-auto divide-y divide-slate-100">
                        <?php $noti = DB::table('notifications')->where('customer',Session::get('id'))->orderBy('id', 'desc')->limit(5); ?>
                        <?php if($noti->count() > 0){ ?>
                            @foreach($noti->get() as $row)
                                <?php $msg = DB::table('msg')->where('id',$row->msg_id)->first(); ?>         
                                <div class="flex gap-3 p-3.5 hover:bg-slate-50 transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[17px]">mail</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[12.5px] font-medium text-slate-800 line-clamp-2 leading-snug">{{ $msg->msg ?? 'Notification received' }}</p>
                                        <div class="flex items-center gap-1.5 text-[11px] text-slate-400 mt-1">
                                            <span>{{ $msg->sender ?? 'System' }}</span>
                                            <span>•</span>
                                            <span>{{ $msg->date ?? date('d M') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        <?php } else { ?>
                            <div class="p-8 flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mb-2 text-slate-300">
                                    <span class="material-symbols-outlined text-[24px]">notifications_none</span>
                                </div>
                                <p class="text-xs font-semibold text-slate-700">All caught up!</p>
                                <p class="text-[11px] text-slate-400">No new notices at this time.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Profile Info & Dropdown (Matching Reference Design) -->
            <div class="relative">
                <div onclick="toggleTopNav('profile-dropdown')" class="flex items-center gap-2.5 pl-2 pr-1 py-1 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors border border-transparent hover:border-slate-200/80">
                    <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden ring-2 ring-slate-200/70 p-0.5 shrink-0">
                        <img alt="User avatar" class="w-full h-full object-cover rounded-full" src="{{ $imgPro }}">
                    </div>
                    <div class="hidden sm:flex flex-col text-left leading-tight">
                        <span class="text-[13px] font-bold text-slate-900 tracking-tight">{{ Session::get('cust_name') ?? 'John Doe' }}</span>
                        <span class="text-[11px] text-slate-400 font-medium">Personal Account</span>
                    </div>
                    <span class="material-symbols-outlined text-[18px] text-slate-400 hidden sm:block">expand_more</span>
                </div>

                <!-- Profile Dropdown -->
                <div id="profile-dropdown" class="hidden absolute top-[52px] right-0 w-[260px] bg-white shadow-xl rounded-2xl border border-slate-100 overflow-hidden z-50 transition-all duration-200 origin-top-right">
                    <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden ring-1 ring-slate-200">
                            <img alt="Profile" class="w-full h-full object-cover" src="{{ $imgPro }}">
                        </div>
                        <div class="min-w-0">
                            <h5 class="text-[13px] font-bold text-slate-900 truncate">{{ Session::get('cust_name') }}</h5>
                            <p class="text-[11px] text-slate-400 font-mono">IP: {{ Session::get('login_ip') }}</p>
                        </div>
                    </div>
                    
                    <div class="py-1.5 text-[13px]">
                        <a href="{{ asset('viewProfile') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-slate-400">person</span>
                            <span>My Profile</span>
                        </a>
                        <a href="{{ asset('editProfile') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-slate-400">manage_accounts</span>
                            <span>Edit Profile</span>
                        </a>
                        <a href="{{ asset('password-update') }}" class="flex items-center gap-2.5 px-4 py-2 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-slate-400">lock_reset</span>
                            <span>Security & PIN</span>
                        </a>
                    </div>
                    
                    <div class="p-2 border-t border-slate-100 bg-slate-50/50">
                        <a href="{{ asset('logout-user') }}" class="flex items-center justify-center gap-2 w-full py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-[12.5px] font-bold transition-colors">
                            <span class="material-symbols-outlined text-[16px]">logout</span>
                            <span>Sign Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

<!-- Global Content Wrapper -->
<main class="flex-1 p-4 lg:p-7 pb-16 overflow-y-auto bg-[#f8f9fb]">

<script type="text/javascript">
    // Mobile Sidebar Drawer Toggle
    function toggleMobileSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        if (sidebar && sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            if(overlay) overlay.classList.remove('hidden');
        } else if (sidebar) {
            sidebar.classList.add('-translate-x-full');
            if(overlay) overlay.classList.add('hidden');
        }
    }

    // TopNav Dropdowns Toggle
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

    // Close Dropdowns on Click Outside
    window.addEventListener('click', function(e) {
        if (!e.target.closest('#notifications-dropdown') && !e.target.closest('[onclick*="notifications-dropdown"]')) {
            const el = document.getElementById('notifications-dropdown');
            if(el) el.classList.add('hidden');
        }
        if (!e.target.closest('#profile-dropdown') && !e.target.closest('[onclick*="profile-dropdown"]')) {
            const el = document.getElementById('profile-dropdown');
            if(el) el.classList.add('hidden');
        }
    });

    // Session Timeout Countdown
    $(document).ready(function() {
        var counter = $('#logout_time').val() || 15;
        initSessionCountdown("countdown", counter, 0);
    });

    function initSessionCountdown(elementName, minutes, seconds) {
        function twoDigits(n) { return (n <= 9 ? "0" + n : n); }
        var element = document.getElementById(elementName);
        var endTime = (+new Date) + 1000 * (60*parseInt(minutes) + parseInt(seconds)) + 500;

        function updateTimer() {
            var msLeft = endTime - (+new Date);
            if (msLeft < 1000) {
                $.ajax({
                    type: 'get',
                    url: "{{ asset('logout-user') }}",
                    success: function() { location.reload(); }
                });
            } else {
                var time = new Date(msLeft);
                var hours = time.getUTCHours();
                var mins = time.getUTCMinutes();
                if(element) {
                    element.innerHTML = (hours ? hours + ':' + twoDigits(mins) : mins) + ':' + twoDigits(time.getUTCSeconds());
                }
                setTimeout(updateTimer, 1000);
            }
        }
        if(element) updateTimer();
    }
</script>
