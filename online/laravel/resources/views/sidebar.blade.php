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

<nav id="sidebar" class="bg-white w-[260px] h-screen fixed left-0 top-0 overflow-y-auto border-r border-[#edf0f4] flex flex-col justify-between py-5 px-3 z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0 shadow-sm">
    <div>
        <!-- Brand Logo -->
        <div class="px-3 pb-6 pt-1 flex items-center justify-between border-b border-slate-100">
            <a href="{{ asset('/') }}" class="flex items-center gap-2.5">
                <?php if(!empty($confiG->logo)){ ?>
                    <img src="/admin/uploads/{{ $confiG->logo }}" alt="{{ $confiG->bank_name }}" class="max-h-10 w-auto object-contain">
                <?php } else { ?>
                    <div class="w-9 h-9 rounded-xl bg-brand-dark flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        <span class="material-symbols-outlined text-brand-gold text-[22px]">account_balance</span>
                    </div>
                    <div>
                        <span class="font-bold text-base tracking-tight text-slate-900 block leading-tight">{{ $confiG->bank_name ?? 'Equitable' }}</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-slate-400 block">Bank Online</span>
                    </div>
                <?php } ?>
            </a>
            <button onclick="toggleMobileSidebar()" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Navigation Links -->
        <div class="flex flex-col gap-1 mt-4">
            <!-- Dashboard -->
            <a href="{{ asset('/') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all {{ ($current_main == 'dashboard' || Request::is('/')) ? 'bg-[#f4f1e8] text-[#9c7614] font-semibold shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <span class="material-symbols-outlined text-[20px] {{ ($current_main == 'dashboard' || Request::is('/')) ? 'text-[#c59b27]' : 'text-slate-400' }}">grid_view</span>
                <span>Dashboard</span>
            </a>

            <!-- My Account -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-account')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'account' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'account' ? 'text-[#c59b27]' : 'text-slate-400' }}">account_balance_wallet</span>
                        <span>Accounts</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'account' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-account">chevron_right</span>
                </button>
                <div id="nav-account" class="{{ $current_main == 'account' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('accounts-summary') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'accounts-summary' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Overview</a>
                    <a href="{{ asset('account-statement') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'account-statement' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Statements</a>
                    <a href="{{ asset('additional-accounts') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'additional-accounts' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Additional Accounts</a>
                    <a href="{{ asset('account-manager') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'account-manager' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Account Manager</a>
                    <a href="{{ asset('statement-to-thirdparty') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'statement-to-thirdparty' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Dispatch Statement</a>
                    <a href="{{ asset('spend-analysis') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'spend-analysis' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Spend Analysis</a>
                </div>
            </div>

            <?php if(isset($_modules) && $_modules->transfer == 1){ ?>
            <!-- Transfer -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-transfer')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'transfer' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'transfer' ? 'text-[#c59b27]' : 'text-slate-400' }}">sync_alt</span>
                        <span>Transfer</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'transfer' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-transfer">chevron_right</span>
                </button>
                <div id="nav-transfer" class="{{ $current_main == 'transfer' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('own-account-transfer') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'own-account-transfer' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Own Account</a>
                    <a href="{{ asset('transfer-to-same-bank') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'transfer-to-same-bank' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Same Bank</a>
                    <a href="{{ asset('transfer-to-other-bank') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'transfer-to-other-bank' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Other Banks / Wire</a>
                    <a href="{{ asset('resume-pending-transfer') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'resume-pending-transfer' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Pending Transfers</a>
                    <a href="{{ asset('manage-beneficiaries') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'manage-beneficiaries' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Beneficiaries</a>
                </div>
            </div>
            <?php } ?>

            <?php if(isset($_modules) && $_modules->cards == 1){ ?>
            <!-- Cards -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-cards')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'card' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'card' ? 'text-[#c59b27]' : 'text-slate-400' }}">credit_card</span>
                        <span>Cards</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'card' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-cards">chevron_right</span>
                </button>
                <div id="nav-cards" class="{{ $current_main == 'card' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('view-cards') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'view-cards' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">My Cards</a>
                    <a href="{{ asset('request-card') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'request-card' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Request Card</a>
                    <a href="{{ asset('update-card-pin') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'update-card-pin' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Update PIN</a>
                </div>
            </div>
            <?php } ?>

            <?php if(isset($_modules) && $_modules->loans == 1){ ?>
            <!-- Loans -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-loans')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'loan' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'loan' ? 'text-[#c59b27]' : 'text-slate-400' }}">account_balance</span>
                        <span>Loans</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'loan' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-loans">chevron_right</span>
                </button>
                <div id="nav-loans" class="{{ $current_main == 'loan' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('loan-summary') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'loan-summary' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Loan Summary</a>
                    <a href="{{ asset('request-loan') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'request-loan' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Apply for Loan</a>
                </div>
            </div>
            <?php } ?>

            <!-- Investments / Portfolio -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-portfolio')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'portfolio' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'portfolio' ? 'text-[#c59b27]' : 'text-slate-400' }}">trending_up</span>
                        <span>Investment</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'portfolio' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-portfolio">chevron_right</span>
                </button>
                <div id="nav-portfolio" class="{{ $current_main == 'portfolio' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('portfolio') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'portfolio' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Portfolio</a>
                    <a href="{{ asset('all_crypto_history') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'all_crypto_history' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Crypto History</a>
                    <a href="{{ asset('all_send_req') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'all_send_req' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Transfers Log</a>
                    <a href="{{ asset('martketplace') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'martketplace' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Marketplace</a>
                    <a href="{{ asset('news') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'news' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Financial News</a>
                </div>
            </div>

            <?php if(isset($_modules) && $_modules->cheque == 1){ ?>
            <!-- Cheques -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-cheques')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'cheque' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'cheque' ? 'text-[#c59b27]' : 'text-slate-400' }}">receipt</span>
                        <span>Cheques</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'cheque' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-cheques">chevron_right</span>
                </button>
                <div id="nav-cheques" class="{{ $current_main == 'cheque' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('request-cheque-book') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'request-cheque-book' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Request Cheque Book</a>
                    <a href="{{ asset('stop-cheque') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'stop-cheque' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Stop Cheque</a>
                </div>
            </div>
            <?php } ?>

            <?php if(isset($_modules) && $_modules->payment_collection == 1){ ?>
            <!-- Payment & Collection -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-payments')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] text-slate-400">payments</span>
                        <span>Pay & Collect</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200" id="icon-nav-payments">chevron_right</span>
                </button>
                <div id="nav-payments" class="hidden flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('pay-invoice') }}" class="px-2.5 py-1.5 rounded-lg text-slate-500 hover:text-slate-900">Pay Invoice</a>
                    <a href="{{ asset('payment-pending') }}" class="px-2.5 py-1.5 rounded-lg text-slate-500 hover:text-slate-900">Unpaid Invoices</a>
                    <a href="{{ asset('payment-part') }}" class="px-2.5 py-1.5 rounded-lg text-slate-500 hover:text-slate-900">Partial Invoices</a>
                    <a href="{{ asset('payment-full') }}" class="px-2.5 py-1.5 rounded-lg text-slate-500 hover:text-slate-900">Settled Invoices</a>
                </div>
            </div>
            <?php } ?>

            <?php if(isset($_modules) && $_modules->account_limit == 1){ ?>
            <!-- Account Limits -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-limits')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] text-slate-400">speed</span>
                        <span>Account Limits</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200" id="icon-nav-limits">chevron_right</span>
                </button>
                <div id="nav-limits" class="hidden flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('request-limit') }}" class="px-2.5 py-1.5 rounded-lg text-slate-500 hover:text-slate-900">Request Limit Change</a>
                    <a href="{{ asset('view-limits') }}" class="px-2.5 py-1.5 rounded-lg text-slate-500 hover:text-slate-900">Current Limits</a>
                </div>
            </div>
            <?php } ?>

            <?php if(isset($_modules) && $_modules->withdraw == 1){ ?>
            <!-- Withdrawals & Deposits -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-withdraw')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-50">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] text-slate-400">price_change</span>
                        <span>Cash & Crypto</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200" id="icon-nav-withdraw">chevron_right</span>
                </button>
                <div id="nav-withdraw" class="hidden flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('user-deposit') }}" class="px-2.5 py-1.5 rounded-lg text-slate-500 hover:text-slate-900">Deposit Funds</a>
                    <a href="{{ asset('view-drawls') }}" class="px-2.5 py-1.5 rounded-lg text-slate-500 hover:text-slate-900">Withdrawal History</a>
                </div>
            </div>
            <?php } ?>

            <?php if(isset($_modules) && $_modules->system_config == 1){ ?>
            <!-- Settings / System Config -->
            <div class="nav-group">
                <button onclick="toggleNav('nav-config')" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl font-medium text-[13.5px] transition-all {{ $current_main == 'config' ? 'text-slate-900 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px] {{ $current_main == 'config' ? 'text-[#c59b27]' : 'text-slate-400' }}">settings</span>
                        <span>Settings</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-slate-400 transition-transform duration-200 {{ $current_main == 'config' ? 'rotate-90 text-[#c59b27]' : '' }}" id="icon-nav-config">chevron_right</span>
                </button>
                <div id="nav-config" class="{{ $current_main == 'config' ? 'flex' : 'hidden' }} flex-col pl-9 pr-2 py-1 gap-1 text-[13px]">
                    <a href="{{ asset('password-update') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'password-update' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">PIN & Password</a>
                    <a href="{{ asset('transaction-alert-activation') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'transaction-alert-activation' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Security Alerts</a>
                    <a href="{{ asset('reset-secret') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'reset-secret' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Secret Questions</a>
                    <a href="{{ asset('update-verification') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'update-verification' ? 'text-[#9c7614] font-semibold bg-[#faf6ed]' : 'text-slate-500 hover:text-slate-900' }}">Verification KYC</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Bottom Promo & Support Area (Equitable Bank Style) -->
    <div class="mt-6 flex flex-col gap-3">
        <!-- Upgrade to Priority Banking Card -->
        <div class="p-4 rounded-2xl bg-gradient-to-br from-[#1b202a] via-[#11141c] to-[#0a0d13] text-white border border-white/10 shadow-lg relative overflow-hidden group">
            <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 mb-2.5">
                <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
            </div>
            <h5 class="text-[13px] font-bold text-white tracking-tight">Upgrade to Priority</h5>
            <p class="text-[11px] text-slate-400 leading-tight mt-1 mb-3">Higher limits, exclusive rewards and dedicated advisor.</p>
            <a href="{{ asset('additional-accounts') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg gold-gradient-btn text-[11px] font-bold tracking-wide w-full justify-center">
                <span>Explore Plans</span>
                <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
            </a>
        </div>

        <!-- Need Help Support Link -->
        <a href="{{ asset('send-message') }}" class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-100 transition-colors">
            <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-xs">
                <span class="material-symbols-outlined text-[18px]">support_agent</span>
            </div>
            <div class="leading-tight">
                <p class="text-[12px] font-bold text-slate-800">Need Help?</p>
                <p class="text-[11px] text-slate-400">Chat with our support</p>
            </div>
        </a>
    </div>
</nav>

<script>
    function toggleNav(id) {
        const el = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        if (el.classList.contains('hidden')) {
            el.classList.remove('hidden');
            el.classList.add('flex');
            if (icon) icon.classList.add('rotate-90', 'text-[#c59b27]');
        } else {
            el.classList.add('hidden');
            el.classList.remove('flex');
            if (icon) icon.classList.remove('rotate-90', 'text-[#c59b27]');
        }
    }
</script>
