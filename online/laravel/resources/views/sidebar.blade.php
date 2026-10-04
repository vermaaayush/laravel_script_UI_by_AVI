<!-- SideNavBar (Stitch Sovereign Banking System) -->
<?php 
    $_modules = DB::table('ba_enable_disable_module')->where('id','1')->first();
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
    $current_page = $page ?? '';
    $current_main = $main ?? '';
?>
<!-- Sidebar overlay (mobile) -->
<div id="sidebar-overlay" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity"></div>

<aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-surface-container-low shadow-[0_1px_8px_rgba(0,0,0,0.03)] z-50 flex flex-col justify-between p-4 sm:p-5 overflow-y-auto transition-transform duration-300 -translate-x-full lg:translate-x-0 border-r border-surface-container-high/60 custom-scrollbar">
    <div class="flex flex-col gap-4">
        <!-- Brand Logo Header -->
        <div class="flex items-center justify-between px-1 min-h-[72px] sm:min-h-[80px] mb-2">
            <a href="{{ url('/') }}" class="flex items-center min-w-0 flex-1 py-1">
                <?php if(!empty($confiG->logo)){ ?>
                    <img src="/admin/uploads/{{ $confiG->logo }}" alt="{{ $confiG->bank_name ?? 'Bank' }}" class="h-16 sm:h-20 w-auto max-w-full max-h-[80px] object-contain object-left transition-all">
                <?php } else { ?>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-[#004226] flex items-center justify-center text-white font-bold shadow-xs shrink-0">
                            <span class="material-symbols-outlined text-[26px]">account_balance</span>
                        </div>
                        <span class="font-bold text-lg text-[#191c1c] tracking-tight block truncate">{{ $confiG->bank_name ?? 'Sovereign Bank' }}</span>
                    </div>
                <?php } ?>
            </a>
            <button onclick="toggleMobileSidebar()" class="lg:hidden p-1.5 rounded-lg text-[#53625b] hover:text-[#191c1c] hover:bg-[#f2f4f3] transition-colors shrink-0">
                <span class="material-symbols-outlined text-[22px]">close</span>
            </button>
        </div>

        <!-- Quick Filter / Search (Matching Stitch Dashboard) -->
        <div class="relative flex items-center bg-white rounded-full px-3 py-1.5 shadow-[0_1px_4px_rgba(0,0,0,0.02)] border border-[#e6e9e8] focus-within:border-[#004226] focus-within:ring-1 focus-within:ring-[#004226]/20 transition-all">
            <span class="material-symbols-outlined text-[#53625b] text-[18px] mr-2 shrink-0 select-none">search</span>
            <input 
                type="text" 
                id="sidebar-quick-search" 
                placeholder="Search accounts, rails..." 
                class="w-full bg-transparent text-xs text-[#191c1c] placeholder:text-[#53625b] font-medium border-0 border-none outline-none p-0 m-0 focus:ring-0 focus:outline-none focus:border-0 shadow-none ring-0 leading-normal" 
                style="border: none !important; outline: none !important; box-shadow: none !important; background: transparent !important; padding: 0 !important; margin: 0 !important;" 
            />
            <span class="px-1.5 py-0.5 rounded bg-[#f2f4f3] text-[#53625b] font-mono text-[10px] font-semibold tracking-wide shrink-0 ml-1 select-none border border-[#e6e9e8]">⌘K</span>
        </div>

        <!-- Navigation Groups -->
        <nav class="flex flex-col gap-3 font-sans">
            <!-- Group 1: Main Menu -->
            <div class="flex flex-col gap-1">
                <span class="px-2 text-[10.5px] font-semibold text-secondary uppercase tracking-wider mb-0.5">Main Menu</span>
                
                <!-- Dashboard -->
                <a href="{{ url('/') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ ($current_main == 'dashboard' || Request::is('/') || Request::is('dashboard')) ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[19px]">grid_view</span>
                        <span class="text-xs">Dashboard</span>
                    </div>
                </a>

                <!-- Accounts Summary -->
                <div class="nav-group">
                    <button onclick="toggleNav('nav-account')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ $current_main == 'account' ? 'bg-surface-container text-on-surface font-semibold' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[19px]">account_balance_wallet</span>
                            <span class="text-xs">Accounts</span>
                        </div>
                        <span class="material-symbols-outlined text-[15px] text-secondary transition-transform duration-200 {{ $current_main == 'account' ? 'rotate-90' : '' }}" id="icon-nav-account">chevron_right</span>
                    </button>
                    <div id="nav-account" class="{{ $current_main == 'account' ? 'flex' : 'hidden' }} flex-col pl-8 pr-1 py-1 gap-0.5 text-xs">
                        <a href="{{ url('accounts-summary') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'accounts-summary' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Overview</a>
                        <a href="{{ url('account-statement') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'account-statement' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Statements</a>
                        <a href="{{ url('additional-accounts') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'additional-accounts' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Additional Accounts</a>
                        <a href="{{ url('account-manager') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'account-manager' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Account Manager</a>
                        <a href="{{ url('spend-analysis') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'spend-analysis' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Spend Analysis</a>
                    </div>
                </div>

                <!-- Transactions Ledger -->
                <a href="{{ url('transactionslist') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ Request::is('transactionslist*') ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[19px]">swap_horiz</span>
                        <span class="text-xs">Transactions</span>
                    </div>
                </a>
            </div>

            <!-- Group 2: Banking Operations -->
            <div class="flex flex-col gap-1">
                <span class="px-2 text-[10.5px] font-semibold text-secondary uppercase tracking-wider mb-0.5">Banking Rails</span>

                <?php if(!isset($_modules) || $_modules->transfer == 1){ ?>
                <!-- Transfer -->
                <div class="nav-group">
                    <button onclick="toggleNav('nav-transfer')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ $current_main == 'transfer' ? 'bg-surface-container text-on-surface font-semibold' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[19px]">send_money</span>
                            <span class="text-xs">Transfers & Wires</span>
                        </div>
                        <span class="material-symbols-outlined text-[15px] text-secondary transition-transform duration-200 {{ $current_main == 'transfer' ? 'rotate-90' : '' }}" id="icon-nav-transfer">chevron_right</span>
                    </button>
                    <div id="nav-transfer" class="{{ $current_main == 'transfer' ? 'flex' : 'hidden' }} flex-col pl-8 pr-1 py-1 gap-0.5 text-xs">
                        <a href="{{ url('own-account-transfer') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'own-account-transfer' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Internal Vault</a>
                        <a href="{{ url('transfer-to-same-bank') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'transfer-to-same-bank' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Same Bank Book</a>
                        <a href="{{ url('transfer-to-other-bank') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'transfer-to-other-bank' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Other Bank Transfer</a>
                        <a href="{{ url('manage-beneficiaries') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'manage-beneficiaries' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Beneficiary Directory</a>
                    </div>
                </div>
                <?php } ?>

                <?php if(!isset($_modules) || $_modules->cards == 1){ ?>
                <!-- Cards -->
                <div class="nav-group">
                    <button onclick="toggleNav('nav-cards')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ $current_main == 'card' ? 'bg-surface-container text-on-surface font-semibold' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[19px]">credit_card</span>
                            <span class="text-xs">Cards</span>
                        </div>
                        <span class="material-symbols-outlined text-[15px] text-secondary transition-transform duration-200 {{ $current_main == 'card' ? 'rotate-90' : '' }}" id="icon-nav-cards">chevron_right</span>
                    </button>
                    <div id="nav-cards" class="{{ $current_main == 'card' ? 'flex' : 'hidden' }} flex-col pl-8 pr-1 py-1 gap-0.5 text-xs">
                        <a href="{{ url('view-cards') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'view-cards' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Active Cards</a>
                        <a href="{{ url('request-card') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'request-card' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Request Issuance</a>
                        <a href="{{ url('update-card-pin') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'update-card-pin' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Card PIN Security</a>
                    </div>
                </div>
                <?php } ?>

                <?php if(!isset($_modules) || $_modules->loans == 1){ ?>
                <!-- Loans -->
                <div class="nav-group">
                    <button onclick="toggleNav('nav-loans')" class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ $current_main == 'loan' ? 'bg-surface-container text-on-surface font-semibold' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[19px]">account_balance</span>
                            <span class="text-xs">Credit & Loans</span>
                        </div>
                        <span class="material-symbols-outlined text-[15px] text-secondary transition-transform duration-200 {{ $current_main == 'loan' ? 'rotate-90' : '' }}" id="icon-nav-loans">chevron_right</span>
                    </button>
                    <div id="nav-loans" class="{{ $current_main == 'loan' ? 'flex' : 'hidden' }} flex-col pl-8 pr-1 py-1 gap-0.5 text-xs">
                        <a href="{{ url('loan-summary') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'loan-summary' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Facilities Summary</a>
                        <a href="{{ url('request-loan') }}" class="px-2.5 py-1.5 rounded-lg transition-colors {{ $current_page == 'request-loan' ? 'text-primary font-bold bg-primary-fixed/30' : 'text-secondary hover:text-on-surface' }}">Credit Application</a>
                    </div>
                </div>
                <?php } ?>

                <?php if(!isset($_modules) || $_modules->cheque == 1){ ?>
                <!-- Cheques -->
                <a href="{{ url('request-cheque-book') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ $current_main == 'cheque' ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[19px]">fact_check</span>
                        <span class="text-xs">Cheque Clearing</span>
                    </div>
                </a>
                <?php } ?>
            </div>

            <!-- Group 3: Treasury & Markets -->
            <div class="flex flex-col gap-1">
                <span class="px-2 text-[10.5px] font-semibold text-secondary uppercase tracking-wider mb-0.5">Treasury & Wealth</span>

                <!-- Investment / Portfolio -->
                <a href="{{ url('portfolio') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ ($current_main == 'portfolio' || Request::is('portfolio*')) ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[19px]">trending_up</span>
                        <span class="text-xs">Portfolio Treasury</span>
                    </div>
                </a>

                <!-- Pay & Collect -->
                <a href="{{ url('pay-invoice') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ $current_main == 'payments' ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[19px]">description</span>
                        <span class="text-xs">Invoices & Collections</span>
                    </div>
                </a>
            </div>

            <!-- Group 4: General -->
            <div class="flex flex-col gap-1">
                <span class="px-2 text-[10.5px] font-semibold text-secondary uppercase tracking-wider mb-0.5">Settings & Desk</span>

                <a href="{{ url('editProfile') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all {{ $current_main == 'profile' ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs' }}">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[19px]">settings</span>
                        <span class="text-xs">Settings & Security</span>
                    </div>
                </a>

                <a href="{{ url('send-message') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl transition-all text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-medium text-xs">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[19px]">support_agent</span>
                        <span class="text-xs">Wealth Desk</span>
                    </div>
                </a>

                <a href="{{ url('logout-user') }}" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-error hover:bg-error-container/40 font-medium text-xs transition-colors">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[19px]">logout</span>
                        <span>Sign Out</span>
                    </div>
                </a>
            </div>
        </nav>
    </div>

    <!-- Institutional Tier Footnote Card (Stitch Upgrade Pro Component) -->
    <div class="mt-4 bg-surface-container-lowest rounded-xl p-3.5 shadow-[0_2px_8px_rgba(15,91,56,0.04)] border border-outline-variant/30">
        <div class="flex items-center gap-1.5 mb-1">
            <span class="material-symbols-outlined text-primary text-[18px]">verified</span>
            <span class="font-heading font-bold text-xs text-on-surface">Sovereign Tier I</span>
        </div>
        <p class="font-sans text-[11px] text-secondary mb-2.5 leading-snug">Quantum-Safe Ledger & High-Capacity Rails</p>
        <div class="flex items-center justify-between gap-2">
            <a href="{{ url('accounts-summary') }}" class="bg-primary text-on-primary rounded-full px-3 py-1 text-[11px] font-semibold hover:bg-primary-container transition-colors shadow-xs">
                Explore Limits
            </a>
            <span class="text-[10px] text-secondary font-mono">FINMA • MAS</span>
        </div>
    </div>
</aside>

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
            icon.classList.add('rotate-90');
        }
    } else {
        el.classList.add('hidden');
        el.classList.remove('flex');
        if (icon) {
            icon.classList.remove('rotate-90');
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
