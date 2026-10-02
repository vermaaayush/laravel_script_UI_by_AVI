<!-- SideNavBar -->
<?php 
    $_modules = DB::table('ba_enable_disable_module')->where('id','1')->first();
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
    $current_page = $page ?? '';
    $current_main = $main ?? '';
?>
<!-- Sidebar overlay (mobile) -->
<div id="sidebar-overlay" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity"></div>

<nav id="sidebar" class="bg-white w-[265px] h-screen fixed left-0 top-0 overflow-y-auto border-r border-slate-200/80 flex flex-col justify-between py-4 px-3.5 z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0 shadow-sm custom-scrollbar">
    <div>
        <!-- Brand Logo -->
        <div class="px-2 pb-4 pt-1 flex items-center justify-between border-b border-slate-100">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <?php if(!empty($confiG->logo)){ ?>
                    <img src="/admin/uploads/{{ $confiG->logo }}" alt="{{ $confiG->bank_name }}" class="max-h-9 w-auto object-contain">
                <?php } else { ?>
                    <div class="w-9 h-9 rounded-xl bg-[#0a0e17] flex items-center justify-center text-white font-bold text-lg shadow-sm border border-[#c59b27]/30">
                        <span class="material-symbols-outlined text-[#dfbb58] text-[22px]">account_balance</span>
                    </div>
                    <div>
                        <span class="font-extrabold text-[15px] tracking-tight text-slate-900 block leading-tight">{{ $confiG->bank_name ?? 'Equitable' }}</span>
                        <span class="text-[9.5px] uppercase font-bold tracking-widest text-[#c59b27] block">Private Wealth</span>
                    </div>
                <?php } ?>
            </a>
            <button onclick="toggleMobileSidebar()" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-col gap-1 mt-3">
            <!-- Dashboard -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ ($current_main == 'dashboard' || Request::is('/') || Request::is('dashboard')) ? 'bg-[#fbf6ea] text-[#9c7614] font-semibold border-l-4 border-[#c59b27]' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <span class="material-symbols-outlined text-[20px] {{ ($current_main == 'dashboard' || Request::is('/') || Request::is('dashboard')) ? 'text-[#c59b27]' : 'text-slate-400' }}">grid_view</span>
                <span>Dashboard</span>
            </a>

            <!-- My Account -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-account')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'account' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'account' ? 'text-[#c59b27]' : 'text-slate-400' }}">account_balance_wallet</span>
                        <span>Accounts</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'account' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-account">chevron_right</span>
                </button>
                <div id="nav-account" class="{{ $current_main == 'account' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-0.5 text-[13px]">
                    <a href="{{ url('accounts-summary') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'accounts-summary' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Overview</a>
                    <a href="{{ url('account-statement') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'account-statement' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Statements</a>
                    <a href="{{ url('additional-accounts') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'additional-accounts' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Additional Accounts</a>
                    <a href="{{ url('account-manager') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'account-manager' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Account Manager</a>
                    <a href="{{ url('statement-to-thirdparty') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'statement-to-thirdparty' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Dispatch Statement</a>
                    <a href="{{ url('spend-analysis') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'spend-analysis' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Spend Analysis</a>
                </div>
            </div>

            <?php if(!isset($_modules) || $_modules->transfer == 1){ ?>
            <!-- Transfer -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-transfer')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'transfer' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'transfer' ? 'text-[#c59b27]' : 'text-slate-400' }}">sync_alt</span>
                        <span>Transfer</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'transfer' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-transfer">chevron_right</span>
                </button>
                <div id="nav-transfer" class="{{ $current_main == 'transfer' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-0.5 text-[13px]">
                    <a href="{{ url('own-account-transfer') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'own-account-transfer' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Own Account</a>
                    <a href="{{ url('transfer-to-same-bank') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'transfer-to-same-bank' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Same Bank</a>
                    <a href="{{ url('transfer-to-other-bank') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'transfer-to-other-bank' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Other Banks / Wire</a>
                    <a href="{{ url('resume-pending-transfer') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'resume-pending-transfer' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Pending Transfers</a>
                    <a href="{{ url('manage-beneficiaries') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'manage-beneficiaries' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Beneficiaries</a>
                </div>
            </div>
            <?php } ?>

            <?php if(!isset($_modules) || $_modules->cards == 1){ ?>
            <!-- Cards -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-cards')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'card' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'card' ? 'text-[#c59b27]' : 'text-slate-400' }}">credit_card</span>
                        <span>Cards</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'card' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-cards">chevron_right</span>
                </button>
                <div id="nav-cards" class="{{ $current_main == 'card' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-0.5 text-[13px]">
                    <a href="{{ url('view-cards') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'view-cards' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">My Cards</a>
                    <a href="{{ url('request-card') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'request-card' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Request Card</a>
                    <a href="{{ url('update-card-pin') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'update-card-pin' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Update PIN</a>
                </div>
            </div>
            <?php } ?>

            <?php if(!isset($_modules) || $_modules->loans == 1){ ?>
            <!-- Loans -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-loans')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'loan' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'loan' ? 'text-[#c59b27]' : 'text-slate-400' }}">account_balance</span>
                        <span>Loans</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'loan' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-loans">chevron_right</span>
                </button>
                <div id="nav-loans" class="{{ $current_main == 'loan' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-0.5 text-[13px]">
                    <a href="{{ url('loan-summary') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'loan-summary' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Loan Summary</a>
                    <a href="{{ url('request-loan') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'request-loan' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Apply for Loan</a>
                </div>
            </div>
            <?php } ?>

            <!-- Investments / Portfolio -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-portfolio')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ ($current_main == 'portfolio' || Request::is('portfolio*')) ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ ($current_main == 'portfolio' || Request::is('portfolio*')) ? 'text-[#c59b27]' : 'text-slate-400' }}">trending_up</span>
                        <span>Investment</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ ($current_main == 'portfolio' || Request::is('portfolio*')) ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-portfolio">chevron_right</span>
                </button>
                <div id="nav-portfolio" class="{{ ($current_main == 'portfolio' || Request::is('portfolio*')) ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-0.5 text-[13px]">
                    <a href="{{ url('portfolio') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ Request::is('portfolio') ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Portfolio</a>
                    <a href="{{ url('all_crypto_history') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ Request::is('all_crypto_history') ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Crypto History</a>
                    <a href="{{ url('all_send_req') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ Request::is('all_send_req') ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Transfers Log</a>
                    <a href="{{ url('martketplace') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ Request::is('martketplace') ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Marketplace</a>
                    <a href="{{ url('news') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ Request::is('news') ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Financial News</a>
                </div>
            </div>

            <?php if(!isset($_modules) || $_modules->cheque == 1){ ?>
            <!-- Cheques -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-cheques')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'cheque' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'cheque' ? 'text-[#c59b27]' : 'text-slate-400' }}">fact_check</span>
                        <span>Cheques</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'cheque' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-cheques">chevron_right</span>
                </button>
                <div id="nav-cheques" class="{{ $current_main == 'cheque' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-0.5 text-[13px]">
                    <a href="{{ url('request-cheque-book') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'request-cheque-book' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Request Cheque</a>
                    <a href="{{ url('stop-cheque') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'stop-cheque' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Stop Cheque</a>
                </div>
            </div>
            <?php } ?>

            <!-- Statements Quick Link -->
            <a href="{{ url('account-statement') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ Request::is('account-statement') ? 'bg-[#fbf6ea] text-[#9c7614] font-semibold border-l-4 border-[#c59b27]' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <span class="material-symbols-outlined text-[20px] {{ Request::is('account-statement') ? 'text-[#c59b27]' : 'text-slate-400' }}">description</span>
                <span>Statements</span>
            </a>

            <!-- Beneficiaries Quick Link -->
            <a href="{{ url('manage-beneficiaries') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ Request::is('manage-beneficiaries') ? 'bg-[#fbf6ea] text-[#9c7614] font-semibold border-l-4 border-[#c59b27]' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <span class="material-symbols-outlined text-[20px] {{ Request::is('manage-beneficiaries') ? 'text-[#c59b27]' : 'text-slate-400' }}">group</span>
                <span>Beneficiaries</span>
            </a>

            <!-- Pay & Collect -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-pay')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'payments' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'payments' ? 'text-[#c59b27]' : 'text-slate-400' }}">receipt_long</span>
                        <span>Pay & Collect</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'payments' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-pay">chevron_right</span>
                </button>
                <div id="nav-pay" class="{{ $current_main == 'payments' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-0.5 text-[13px]">
                    <a href="{{ url('pay-invoice') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'pay-invoice' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Pay Invoice</a>
                    <a href="{{ url('pending-payment') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'pending-payment' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Pending Invoices</a>
                </div>
            </div>

            <!-- Settings -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-settings')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'profile' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'profile' ? 'text-[#c59b27]' : 'text-slate-400' }}">settings</span>
                        <span>Settings</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'profile' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-settings">chevron_right</span>
                </button>
                <div id="nav-settings" class="{{ $current_main == 'profile' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-0.5 text-[13px]">
                    <a href="{{ url('viewProfile') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'viewProfile' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">View Profile</a>
                    <a href="{{ url('editProfile') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'editProfile' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Edit Profile</a>
                    <a href="{{ url('password-update') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'password-update' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Security PIN</a>
                    <a href="{{ url('reset-secret') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'reset-secret' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Secret Question</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Sidebar Widgets (Exact Reference Design) -->
    <div class="mt-6 pt-3 flex flex-col gap-3">
        <!-- Priority Banking Card -->
        <div class="rounded-2xl bg-gradient-to-br from-[#121824] via-[#0d121c] to-[#1c1810] p-4 text-white border border-[#c59b27]/30 shadow-md relative overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-[#c59b27]/15 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center gap-2 mb-2 relative z-10">
                <div class="w-7 h-7 rounded-lg bg-[#c59b27]/20 border border-[#c59b27]/40 flex items-center justify-center text-[#dfbb58]">
                    <span class="material-symbols-outlined text-[16px]">crown</span>
                </div>
                <h4 class="text-xs font-bold text-white tracking-wide">Upgrade to Priority</h4>
            </div>
            <p class="text-[11px] text-slate-300 leading-snug mb-3 relative z-10">
                Higher limits, exclusive rewards and dedicated private wealth support.
            </p>
            <a href="{{ url('accounts-summary') }}" class="w-full py-1.5 px-3 rounded-xl gold-gradient-btn text-center text-[11px] font-bold block transition-all shadow-xs relative z-10">
                Explore Plans &rarr;
            </a>
        </div>

        <!-- Need Help Widget -->
        <a href="{{ url('send-message') }}" class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 hover:bg-slate-100/80 border border-slate-200/80 transition-colors">
            <div class="w-8 h-8 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700">
                <span class="material-symbols-outlined text-[18px]">headphones</span>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-900 leading-tight">Need Help?</p>
                <p class="text-[10.5px] text-slate-500">Chat with support</p>
            </div>
        </a>
    </div>
</nav>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>

<script>
function toggleNav(navId) {
    const el = document.getElementById(navId);
    const icon = document.getElementById('icon-' + navId);
    if (!el) return;
    
    if (el.classList.contains('hidden')) {
        el.classList.remove('hidden');
        el.classList.add('flex');
        if (icon) {
            icon.classList.add('rotate-90', 'text-[#c59b27]');
        }
    } else {
        el.classList.add('hidden');
        el.classList.remove('flex');
        if (icon) {
            icon.classList.remove('rotate-90', 'text-[#c59b27]');
        }
    }
}

function toggleMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (!sidebar) return;
    
    if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        if (overlay) overlay.classList.remove('hidden');
    } else {
        sidebar.classList.add('-translate-x-full');
        if (overlay) overlay.classList.add('hidden');
    }
}
</script>
