<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

@php
    $user_id = session()->get('user_id');
    $cust_name = $cust_name ?? (session()->get('cust_name') ?? 'Valued Client');
    $first_name = explode(' ', trim($cust_name))[0];

    // Dynamic accounts from database
    $userAccounts = $all_accounts ?? [];
    if(empty($userAccounts) && $user_id) {
        $userAccounts = DB::table('ba_user_accounts')->where('user_id', $user_id)->orderBy('id', 'asc')->get();
    }
    
    $primaryAcc = count($userAccounts) > 0 ? $userAccounts[0] : null;
    $cur = $currency ?? ($primaryAcc->account_currency ?? '$');
    $main_balance = $balance ?? ($primaryAcc->available_balance ?? 0.00);
    $acno = $acno ?? ($primaryAcc ? ('•••• ' . substr($primaryAcc->account_no, -4)) : 'N/A');
    $full_acno = $full_acno ?? ($primaryAcc->account_no ?? 'N/A');
    $actype = $actype ?? ($primaryAcc->account_type ?? 'Commercial Checking');

    // Dynamic Inflows & Outflows from ba_transactions
    $txList = $transactions ?? [];
    if(empty($txList) && $user_id) {
        $txList = DB::table('ba_transactions')->where('user_id', $user_id)->orderBy('datetime', 'desc')->take(10)->get();
    }

    $inflowTotal = $total_inflow ?? 0;
    $inflowCnt = $inflow_count ?? 0;
    $outflowTotal = $total_outflow ?? 0;
    $outflowCnt = $outflow_count ?? 0;

    if(!isset($total_inflow) && $user_id) {
        $allTx = DB::table('ba_transactions')->where('user_id', $user_id)->get();
        foreach($allTx as $tx) {
            $amt = (float)($tx->amount ?? 0);
            $type = strtolower($tx->type ?? '');
            if($type == 'credited' || $type == 'credit') {
                $inflowTotal += $amt;
                $inflowCnt++;
            } elseif($type == 'debited' || $type == 'debit' || $type == 'charges' || $type == 'charge') {
                $outflowTotal += $amt;
                $outflowCnt++;
            }
        }
    }

    $userCards = $cards ?? [];
    if(empty($userCards) && $user_id) {
        $userCards = DB::table('ba_cards')->where('user_id', $user_id)->get();
    }
@endphp

<div class="flex flex-col w-full gap-5 pb-12 font-sans">

    <!-- TOP SOVEREIGN HERO BANNER (Luxurious Sovereign Green Theme with Architecture Backdrop & Green Overlay) -->
    <div class="relative overflow-hidden rounded-3xl bg-[#002616] text-white p-6 sm:p-8 shadow-xl border border-emerald-900/40">
        <!-- Architectural Luxury Backdrop Image -->
        <div class="absolute inset-0 bg-cover bg-center pointer-events-none opacity-30 mix-blend-luminosity scale-105" style="background-image: url('{{ asset('images/hero_architecture_banner.jpg') }}');"></div>
        
        <!-- Sovereign Rich Green Gradients Overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#002b19]/95 via-[#003d23]/88 to-[#054d2f]/82 pointer-events-none"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#002213] via-transparent to-transparent pointer-events-none opacity-60"></div>

        <!-- Ambient glowing orbs & subtle lattice pattern -->
        <div class="absolute -right-16 -top-16 w-72 h-72 rounded-full bg-emerald-400/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-56 h-56 rounded-full bg-emerald-500/15 blur-2xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-[0.03] pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <!-- Left: Greeting & Status Badges -->
            <div class="space-y-3">
                <div class="flex items-center gap-2.5 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-emerald-200 text-xs font-semibold border border-white/15 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Secure Banking • Verified Account
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/5 backdrop-blur-md text-emerald-100/80 text-xs font-mono border border-white/10">
                        <span class="material-symbols-outlined text-[14px] text-emerald-300">calendar_today</span>
                        {{ date('D, d M Y') }}
                    </span>
                </div>

                <div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-4xl text-white tracking-tight leading-tight">
                        Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 via-white to-emerald-100">{{ $first_name }}</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-emerald-100/90 mt-1 max-w-xl font-normal leading-relaxed">
                        Manage your accounts, send money, and track transactions securely.
                    </p>
                </div>
            </div>

            <!-- Right: Action Buttons in a Clean Responsive Row -->
            <div class="flex items-center gap-3 flex-wrap sm:flex-nowrap shrink-0">
                <a href="{{ url('account-statement') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/20 text-xs font-semibold shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[17px] text-emerald-300">download</span>
                    <span>Statement</span>
                </a>
                <a href="{{ url('transfer-to-same-bank') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/20 text-xs font-semibold shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[17px] text-emerald-300">send</span>
                    <span>Transfer</span>
                </a>
                <a href="{{ url('transfer-to-other-bank') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-400 to-emerald-300 hover:from-emerald-300 hover:to-white text-[#00331e] text-xs font-extrabold shadow-lg shadow-emerald-950/40 transition-all hover:scale-[1.03] active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[18px]">account_balance</span>
                    <span>New Wire Transfer</span>
                </a>
            </div>
        </div>
    </div>

    @php
        $totalTurnover = $inflowTotal + $outflowTotal;
        $inflowPct = $totalTurnover > 0 ? round(($inflowTotal / $totalTurnover) * 100, 1) : 50;
        $outflowPct = $totalTurnover > 0 ? round(100 - $inflowPct, 1) : 50;
        $netPosition = $inflowTotal - $outflowTotal;
        $isSurplus = ($netPosition >= 0);
    @endphp

    <!-- TOP METRICS & CASHFLOW PROGRESS METER (Green Card + Comparative Split Meter) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Card 1: Primary Operating Ledger (Hero Sovereign Gradient) -->
        <div class="lg:col-span-4 relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#004226] via-[#085232] to-[#0f5b38] text-white p-6 shadow-md flex flex-col justify-between group transition-all duration-300 hover:shadow-xl">
            <!-- Decorative ambient aura -->
            <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div>
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/15 backdrop-blur-md flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-[22px]">account_balance_wallet</span>
                        </div>
                        <div>
                            <p class="font-heading font-semibold text-base text-white leading-tight">Operating Balance</p>
                            <p class="text-xs text-white/80 font-mono">{{ $actype }} • {{ $acno }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-white/20 text-white text-[11px] font-semibold backdrop-blur-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                        Active
                    </span>
                </div>
                <div class="mt-6 flex flex-wrap items-baseline justify-between gap-2">
                    <div class="flex items-baseline min-w-0">
                        <span class="text-xs sm:text-sm font-extrabold text-emerald-200 mr-1.5 select-none shrink-0">{{ $cur }}</span>
                        <span class="font-heading font-extrabold text-2xl lg:text-xl xl:text-2xl 2xl:text-3xl tracking-tight text-white truncate tabular-nums">
                            {{ number_format($main_balance, 2) }}
                        </span>
                    </div>
                    <span class="text-xs text-white/80 font-medium">
                        {{ count($userAccounts) }} {{ count($userAccounts) == 1 ? 'Operating Account' : 'Operating Accounts' }}
                    </span>
                </div>
            </div>
            <div class="mt-6 pt-3 flex items-center justify-between text-white/90 border-t border-white/15">
                <a href="{{ url('account-statement') }}" class="text-xs font-semibold hover:text-white flex items-center gap-1">
                    <span>Export Statement</span>
                    <span class="material-symbols-outlined text-[16px] group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
                </a>
                <a href="{{ url('accounts-summary') }}" class="text-xs font-semibold text-white/70 hover:text-white">
                    <span>All Accounts</span>
                </a>
            </div>
        </div>

        <!-- Card 2: Visual Cashflow & Liquidity Progress Meter (Col 8) -->
        <div class="lg:col-span-8 rounded-2xl bg-surface-container-lowest p-6 border border-outline-variant/30 shadow-sm flex flex-col justify-between group hover:shadow-md transition-all duration-300">
            <div>
                <!-- Top Status Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-surface-container">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-[#004226] border border-emerald-100 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[22px]">swap_horiz</span>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-base text-on-surface">Cashflow Dynamics & Volume Split</h3>
                            <p class="text-xs text-secondary">
                                @if(($inflowCnt + $outflowCnt) > 0)
                                    Comparing inbound deposits vs outbound dispatches ({{ $inflowCnt + $outflowCnt }} total)
                                @else
                                    No ledger transactions recorded in active period
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full {{ $isSurplus ? 'bg-emerald-50 text-[#004226] border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }} text-xs font-bold whitespace-nowrap shadow-xs">
                            <span class="w-2 h-2 rounded-full {{ $isSurplus ? 'bg-[#004226]' : 'bg-amber-600' }} shrink-0"></span>
                            <span class="tabular-nums font-semibold">{{ $isSurplus ? '+' : '-' }}{{ $cur }} {{ number_format(abs($netPosition), 2) }}</span>
                            <span class="text-[11px] font-bold uppercase tracking-wider">{{ $netPosition == 0 ? 'Balanced' : ($isSurplus ? 'Surplus' : 'Deficit') }}</span>
                        </span>
                    </div>
                </div>

                <!-- Main Volume Breakdown (Two Columns: Inflow vs Outflow) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 my-4">
                    <!-- Inbound Liquidity Stats -->
                    <div class="p-4 rounded-xl bg-gradient-to-br from-[#f2f8f4] to-[#e7f3ec] border border-[#cfe5d8] relative overflow-hidden transition-all hover:border-[#b5d9c3]">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-[#004226] flex items-center gap-1.5 uppercase tracking-wider text-[11px]">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#004226]"></span>
                                Inbound Flow
                            </span>
                            <span class="text-xs font-bold text-[#004226] bg-white/80 px-2.5 py-0.5 rounded-full border border-[#c2dfcd] tabular-nums">
                                {{ $inflowPct }}%
                            </span>
                        </div>
                        <div class="mt-2.5 flex items-baseline gap-1.5">
                            <span class="font-heading font-extrabold text-2xl sm:text-3xl text-[#004226] tracking-tight tabular-nums">
                                +{{ $cur }} {{ number_format($inflowTotal, 2) }}
                            </span>
                        </div>
                        <p class="text-[11px] text-[#28573e] mt-1.5 font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">check_circle</span>
                            {{ $inflowCnt }} {{ $inflowCnt == 1 ? 'Credit deposit' : 'Credit deposits' }} recorded
                        </p>
                    </div>

                    <!-- Outbound Dispatches Stats -->
                    <div class="p-4 rounded-xl bg-gradient-to-br from-[#f8fafc] to-[#f1f5f9] border border-[#e2e8f0] relative overflow-hidden transition-all hover:border-slate-300">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-700 flex items-center gap-1.5 uppercase tracking-wider text-[11px]">
                                <span class="w-2.5 h-2.5 rounded-full bg-slate-500"></span>
                                Outbound Flow
                            </span>
                            <span class="text-xs font-bold text-slate-600 bg-white/80 px-2.5 py-0.5 rounded-full border border-slate-200 tabular-nums">
                                {{ $outflowPct }}%
                            </span>
                        </div>
                        <div class="mt-2.5 flex items-baseline gap-1.5">
                            <span class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-800 tracking-tight tabular-nums">
                                -{{ $cur }} {{ number_format($outflowTotal, 2) }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1.5 font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">arrow_outward</span>
                            {{ $outflowCnt }} {{ $outflowCnt == 1 ? 'Debit dispatch' : 'Debit dispatches' }} recorded
                        </p>
                    </div>
                </div>

                <!-- Visual Comparative Split Progress Bar -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-xs">
                        <span class="flex items-center gap-1 font-semibold text-[#004226]">
                            <span class="material-symbols-outlined text-[14px]">arrow_downward</span>
                            Inbound Share ({{ $inflowPct }}%)
                        </span>
                        <span class="flex items-center gap-1 font-semibold text-slate-600">
                            Outbound Share ({{ $outflowPct }}%)
                            <span class="material-symbols-outlined text-[14px]">arrow_upward</span>
                        </span>
                    </div>

                    <!-- Dual Segment Colored Bar -->
                    <div class="w-full h-3 rounded-full bg-slate-100 overflow-hidden flex p-0.5 border border-slate-200/70 shadow-inner">
                        <div class="h-full bg-gradient-to-r from-[#004226] to-[#0d5937] transition-all duration-500 rounded-l-full" style="width: {{ $inflowPct }}%"></div>
                        <div class="h-full bg-gradient-to-r from-slate-500 to-slate-600 transition-all duration-500 rounded-r-full" style="width: {{ $outflowPct }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Bottom Telemetry & Navigation -->
            <div class="mt-4 pt-3.5 flex flex-wrap items-center justify-between gap-3 text-xs border-t border-surface-container">
                <div class="flex items-center gap-2">
                    <span class="text-secondary font-medium">Total Volume:</span>
                    <strong class="font-heading font-extrabold text-on-surface text-sm tabular-nums">{{ $cur }} {{ number_format($totalTurnover, 2) }}</strong>
                </div>
                <a href="{{ url('spend-analysis') }}" class="font-bold text-[#004226] hover:text-[#0b4d30] flex items-center gap-1 group/link transition-colors">
                    <span>Full Spend & Cashflow Analytics</span>
                    <span class="material-symbols-outlined text-[15px] group-hover/link:translate-x-0.5 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>

    <!-- MIDDLE SECTION: MULTI-CURRENCY OPERATING ACCOUNTS (Col 5) & TRADINGVIEW FX/MARKET OVERVIEW (Col 7) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- LEFT: Operating Accounts & Rails (Col 5) -->
        <div class="lg:col-span-5 rounded-2xl bg-surface-container-lowest p-6 border border-outline-variant/30 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-heading font-bold text-lg text-on-surface">Operating Accounts</h2>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            <p class="text-xs text-secondary">Verified Customer Treasury Vaults</p>
                        </div>
                    </div>
                    <a href="{{ url('additional-accounts') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-surface-container-low text-on-surface text-xs font-semibold hover:bg-surface-container transition-colors border border-outline-variant/20">
                        <span class="material-symbols-outlined text-[16px] text-primary">add</span>
                        <span>Open Account</span>
                    </a>
                </div>

                <!-- Dynamic Accounts Loop -->
                <div class="space-y-3 mt-4">
                    @forelse($userAccounts as $accItem)
                        @php
                            $accCur = $accItem->account_currency ?: 'USD';
                            $accBal = (float)($accItem->available_balance ?? 0);
                            $flag = ($accCur == 'CAD') ? '🇨🇦' : (($accCur == 'EUR') ? '🇪🇺' : (($accCur == 'GBP') ? '🇬🇧' : '🇺🇸'));
                        @endphp
                        <div class="rounded-xl bg-surface-container-low p-4 hover:bg-surface-container transition-all group relative border border-outline-variant/20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xl leading-none">{{ $flag }}</span>
                                    <div>
                                        <span class="font-heading font-bold text-sm text-on-surface block">
                                            {{ $accItem->account_type ?: 'Operating Vault' }} ({{ $accCur }})
                                        </span>
                                        <span class="text-[11px] text-secondary font-mono">
                                            Acc: •••• {{ substr($accItem->account_no, -4) }}
                                        </span>
                                    </div>
                                </div>
                                <span class="text-[11px] font-bold text-primary bg-primary/10 px-2.5 py-0.5 rounded-full">
                                    Active
                                </span>
                            </div>
                            <div class="mt-3 flex items-baseline justify-between">
                                <div>
                                    <p class="font-heading font-bold text-lg text-on-surface font-mono">
                                        {{ $accCur }} {{ number_format($accBal, 2) }}
                                    </p>
                                </div>
                                <a href="{{ url('account-statement') }}" class="text-xs text-primary font-semibold hover:underline flex items-center gap-0.5">
                                    <span>Statement</span>
                                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center rounded-xl bg-surface-container-low border border-dashed border-outline-variant/40">
                            <span class="material-symbols-outlined text-[32px] text-secondary mb-1">account_balance</span>
                            <p class="text-xs font-semibold text-on-surface">No secondary accounts configured</p>
                            <a href="{{ url('additional-accounts') }}" class="text-xs font-bold text-primary hover:underline mt-1 inline-block">
                                + Request Additional Currency Account
                            </a>
                        </div>
                    @endforelse

                    @if(count($userAccounts) == 1)
                        <!-- Secondary Account Requisition Banner -->
                        <a href="{{ url('additional-accounts') }}" class="block rounded-xl border border-dashed border-outline-variant/40 p-3.5 hover:bg-surface-container-low transition-colors group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                    </span>
                                    <div>
                                        <p class="text-xs font-bold text-on-surface">Open Multi-Currency Vault</p>
                                        <p class="text-[11px] text-secondary">Add EUR, GBP, USD, or CAD accounts instantly</p>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-[18px] text-secondary group-hover:translate-x-0.5 transition-transform">chevron_right</span>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Fast Banking Action Rails -->
            <div class="mt-6 pt-4 border-t border-surface-container grid grid-cols-4 gap-2 text-center">
                <a href="{{ url('transfer-to-same-bank') }}" class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-surface-container transition-all group">
                    <div class="w-9 h-9 rounded-full bg-primary-fixed/50 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">send</span>
                    </div>
                    <span class="text-xs font-semibold text-on-surface">Internal</span>
                </a>
                <a href="{{ url('transfer-to-other-bank') }}" class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-surface-container transition-all group">
                    <div class="w-9 h-9 rounded-full bg-secondary-container/50 flex items-center justify-center text-secondary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">account_balance</span>
                    </div>
                    <span class="text-xs font-semibold text-on-surface">Wire FX</span>
                </a>
                <a href="{{ url('account-statement') }}" class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-surface-container transition-all group">
                    <div class="w-9 h-9 rounded-full bg-secondary-container/50 flex items-center justify-center text-secondary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">description</span>
                    </div>
                    <span class="text-xs font-semibold text-on-surface">Statement</span>
                </a>
                <a href="{{ url('manage-beneficiaries') }}" class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-surface-container transition-all group">
                    <div class="w-9 h-9 rounded-full bg-secondary-container/50 flex items-center justify-center text-secondary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">group</span>
                    </div>
                    <span class="text-xs font-semibold text-on-surface">Payees</span>
                </a>
            </div>
        </div>

        <!-- RIGHT: TradingView Institutional Market & FX Overview (Col 7) -->
        <div class="lg:col-span-7 rounded-2xl bg-surface-container-lowest p-6 border border-outline-variant/30 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h2 class="font-heading font-bold text-lg text-on-surface">Global Treasury & FX Rails</h2>
                        <p class="text-xs text-secondary">Real-time interbank foreign exchange & commodity liquidity benchmarks</p>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#eaf4ee] text-[#004226] text-[11px] font-bold border border-[#c4e3cf]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#004226] animate-pulse"></span>
                        Live Feed
                    </span>
                </div>

                <!-- TradingView Symbol Overview Interactive Chart -->
                <div class="rounded-xl overflow-hidden mt-3 border border-outline-variant/20 bg-white" style="height: 330px;">
                    <div class="tradingview-widget-container" style="height: 100%; width: 100%;">
                        <div class="tradingview-widget-container__widget" style="height: 100%; width: 100%;"></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
                        {
                            "symbols": [
                                [ "EUR/USD", "FX_IDC:EURUSD|1D" ],
                                [ "GBP/USD", "FX_IDC:GBPUSD|1D" ],
                                [ "USD/CAD", "FX_IDC:USDCAD|1D" ],
                                [ "USD/JPY", "FX_IDC:USDJPY|1D" ],
                                [ "Gold", "TVC:GOLD|1D" ],
                                [ "Bitcoin", "BITSTAMP:BTCUSD|1D" ]
                            ],
                            "chartOnly": false,
                            "width": "100%",
                            "height": "100%",
                            "locale": "en",
                            "colorTheme": "light",
                            "autosize": true,
                            "showVolume": false,
                            "showMA": false,
                            "hideDateRanges": false,
                            "hideMarketStatus": false,
                            "hideSymbolLogo": false,
                            "scalePosition": "right",
                            "scaleMode": "Normal",
                            "fontFamily": "Inter, -apple-system, BlinkMacSystemFont, sans-serif",
                            "fontSize": "11",
                            "noTimeScale": false,
                            "valuesTracking": "1",
                            "changeMode": "price-and-percent",
                            "chartType": "area",
                            "lineColor": "#004226",
                            "topColor": "rgba(0, 66, 38, 0.28)",
                            "bottomColor": "rgba(0, 66, 38, 0.02)",
                            "lineWidth": 2,
                            "headerFontSize": "small",
                            "dateRanges": [
                                "1d|1",
                                "1m|30",
                                "3m|60",
                                "12m|1D",
                                "all|1M"
                            ]
                        }
                        </script>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 flex items-center justify-between text-secondary text-xs border-t border-surface-container">
                <span class="font-mono">Streaming 24/7 Global Interbank Clearing Benchmarks</span>
                <a href="{{ url('martketplace') }}" class="font-bold text-[#004226] hover:underline flex items-center gap-1">
                    <span>Full Market Matrix</span>
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>

    <!-- BOTTOM SECTION: COMPREHENSIVE ACTIVITY TABLE (Col 8) + EXECUTIVE CARDS & FACILITIES (Col 4) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- MAIN TABLE: Recent Verified Settlements & Ledger Activity (Col 8) -->
        <div class="lg:col-span-8 rounded-2xl bg-surface-container-lowest p-6 border border-outline-variant/30 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                    <div>
                        <h2 class="font-heading font-bold text-lg text-on-surface">Recent Settlements & Verified Ledger</h2>
                        <p class="text-xs text-secondary">Real-time ledger entries from your institutional custody account</p>
                    </div>
                    <!-- Table Controls -->
                    <div class="flex items-center gap-2">
                        <div class="relative flex items-center bg-surface-container-low rounded-lg px-2.5 py-1.5 focus-within:bg-surface-container border border-outline-variant/20">
                            <span class="material-symbols-outlined text-secondary text-[18px] mr-1.5">search</span>
                            <input class="bg-transparent text-xs text-on-surface placeholder:text-secondary focus:outline-none w-32 sm:w-44" id="activity-search" oninput="filterActivities(this.value)" placeholder="Search transactions..." type="text"/>
                        </div>
                        <a href="{{ url('transactionslist') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container-low text-on-surface text-xs font-semibold hover:bg-surface-container transition-colors border border-outline-variant/20">
                            <span class="material-symbols-outlined text-[16px] text-secondary">tune</span>
                            <span>All Records</span>
                        </a>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="text-secondary text-[11px] uppercase tracking-wider font-semibold border-b border-surface-container bg-surface-container-low/50">
                                <th class="py-3 px-3">Transaction</th>
                                <th class="py-3 px-3">Reference ID</th>
                                <th class="py-3 px-3">Timestamp</th>
                                <th class="py-3 px-3 text-right">Amount</th>
                                <th class="py-3 px-3 text-center">Status</th>
                                <th class="py-3 px-2 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container" id="activity-table-body">
                            @forelse($txList as $tr)
                                @php
                                    $rawType = strtolower($tr->type ?? '');
                                    $isCredit = ($rawType == 'credited' || $rawType == 'credit');
                                    $isCharge = ($rawType == 'charges' || $rawType == 'charge');
                                    $amt = (float)($tr->amount ?? 0);
                                    $dateStr = !empty($tr->datetime) ? date('d M Y, H:i', strtotime($tr->datetime)) : (!empty($tr->created_at) ? date('d M Y, H:i', strtotime($tr->created_at)) : 'Recent');
                                    $refId = !empty($tr->tran_id) ? $tr->tran_id : ('TXN_' . substr(md5($tr->id ?? rand()), 0, 8));
                                    $reason = !empty($tr->reason) ? $tr->reason : ($isCredit ? 'Inbound Account Settlement' : ($isCharge ? 'Operational Service Surcharge' : 'Institutional Outbound Wire'));
                                @endphp
                                <tr class="activity-row hover:bg-surface-container-low transition-colors group">
                                    <td class="py-3 px-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg {{ $isCredit ? 'bg-[#eaf4ee] text-[#004226]' : ($isCharge ? 'bg-amber-50 text-amber-700' : 'bg-surface-container text-secondary') }} flex items-center justify-center font-bold text-xs shrink-0">
                                                <span class="material-symbols-outlined text-[18px]">
                                                    {{ $isCredit ? 'arrow_downward' : ($isCharge ? 'receipt_long' : 'arrow_upward') }}
                                                </span>
                                            </div>
                                            <div class="min-w-0">
                                                <span class="font-heading font-semibold text-xs text-on-surface block truncate max-w-[200px] sm:max-w-xs">
                                                    {{ $reason }}
                                                </span>
                                                <span class="text-[11px] text-secondary font-mono">
                                                    {{ $isCredit ? 'Credit Settlement' : ($isCharge ? 'Clearing Fee' : 'Debit Outflow') }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 font-mono text-secondary text-[11px] whitespace-nowrap">{{ $refId }}</td>
                                    <td class="py-3 px-3 text-secondary text-[11px] whitespace-nowrap">{{ $dateStr }}</td>
                                    <td class="py-3 px-3 text-right font-mono font-bold whitespace-nowrap {{ $isCredit ? 'text-[#004226]' : ($isCharge ? 'text-amber-800' : 'text-on-surface') }}">
                                        {{ $isCredit ? '+' : '-' }}{{ $cur }} {{ number_format($amt, 2) }}
                                    </td>
                                    <td class="py-3 px-3 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#eaf4ee] text-[#004226] font-semibold text-[11px] border border-[#c4e3cf]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#004226]"></span>
                                            Settled
                                        </span>
                                    </td>
                                    <td class="py-3 px-2 text-right">
                                        <a href="{{ url('transactionslist') }}" class="text-secondary hover:text-on-surface p-1 rounded hover:bg-surface-container inline-block">
                                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <!-- Clean Elegant Empty State (No fake static mock data) -->
                                <tr>
                                    <td colspan="6" class="py-12 px-4 text-center">
                                        <div class="max-w-sm mx-auto flex flex-col items-center">
                                            <div class="w-12 h-12 rounded-2xl bg-surface-container-low flex items-center justify-center text-secondary mb-3">
                                                <span class="material-symbols-outlined text-[28px]">receipt_long</span>
                                            </div>
                                            <h4 class="font-heading font-bold text-sm text-on-surface">No Settlement History Yet</h4>
                                            <p class="text-xs text-secondary mt-1 leading-relaxed">
                                                Your institutional custody account is active. Dispatched wires and inbound credits will appear here with live clearing verification.
                                            </p>
                                            <div class="mt-4 flex items-center gap-2">
                                                <a href="{{ url('transfer-to-other-bank') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#004226] text-white text-xs font-bold shadow-sm hover:bg-[#085232] transition-colors">
                                                    <span class="material-symbols-outlined text-[15px]">send</span>
                                                    <span>New Wire</span>
                                                </a>
                                                <a href="{{ url('account-statement') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container-low text-on-surface text-xs font-semibold hover:bg-surface-container transition-colors">
                                                    <span>Statement</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer info -->
            <div class="mt-4 pt-3 flex items-center justify-between text-secondary text-xs border-t border-surface-container">
                <span class="font-mono">Displaying verified customer transactions</span>
                <div class="flex items-center gap-2">
                    <a href="{{ url('transactionslist') }}" class="text-[#004226] font-bold hover:underline flex items-center gap-1">
                        <span>Full Transaction History</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- RIGHT COMPLEMENTARY: CORPORATE CARDS & TREASURY INTELLIGENCE (Col 4) -->
        <div class="lg:col-span-4 flex flex-col gap-5">
            <!-- Executive Debit / Corporate Card Container -->
            <div class="rounded-2xl bg-surface-container-lowest p-6 border border-outline-variant/30 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="font-heading font-bold text-sm text-on-surface block">Commercial Card Facility</span>
                        <span class="text-[11px] text-secondary">Contactless Visa / Mastercard Rail</span>
                    </div>
                    <a href="{{ url('view-cards') }}" class="material-symbols-outlined text-secondary text-[20px] hover:text-on-surface" title="View Cards">credit_card</a>
                </div>

                @if(count($userCards) > 0)
                    @php $cardItem = $userCards[0]; @endphp
                    <!-- Active User Issued Card -->
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-tr from-[#191c1c] via-[#242826] to-[#004226] text-white p-6 shadow-xl border border-white/10 group transition-transform hover:scale-[1.01] duration-300">
                        <div class="flex items-start justify-between">
                            <span class="font-heading font-bold tracking-wider text-emerald-300 text-sm">Institutional Commercial</span>
                            <span class="material-symbols-outlined text-[24px] text-emerald-300">contactless</span>
                        </div>
                        <div class="my-6">
                            <div class="w-10 h-7 rounded bg-amber-200/90 mb-3 flex items-center justify-center shadow-inner">
                                <div class="w-7 h-5 border border-amber-900/40 rounded-sm"></div>
                            </div>
                            <p class="font-mono text-base tracking-widest text-white/90">
                                •••• •••• •••• {{ substr($cardItem->card_number ?? '9201', -4) }}
                            </p>
                        </div>
                        <div class="flex items-end justify-between text-xs text-white/70">
                            <div>
                                <p class="text-[10px] uppercase tracking-wider text-white/50">Card Holder</p>
                                <p class="text-white font-medium uppercase font-mono">{{ $cust_name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-wider text-right text-white/50">Expires</p>
                                <p class="text-white font-medium font-mono">{{ $cardItem->expiry ?? '12/28' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Sovereign Card Requisition Preview (If user has not ordered card yet) -->
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-tr from-[#191c1c] via-[#242826] to-[#004226] text-white p-6 shadow-xl border border-white/10 group transition-transform hover:scale-[1.01] duration-300">
                        <div class="flex items-start justify-between">
                            <span class="font-heading font-bold tracking-wider text-emerald-300 text-sm">Institutional Commercial</span>
                            <span class="material-symbols-outlined text-[24px] text-emerald-300">contactless</span>
                        </div>
                        <div class="my-6">
                            <div class="w-10 h-7 rounded bg-amber-200/90 mb-3 flex items-center justify-center shadow-inner">
                                <div class="w-7 h-5 border border-amber-900/40 rounded-sm"></div>
                            </div>
                            <p class="font-mono text-base tracking-widest text-white/90">
                                •••• •••• •••• ••••
                            </p>
                        </div>
                        <div class="flex items-end justify-between text-xs text-white/70">
                            <div>
                                <p class="text-[10px] uppercase tracking-wider text-white/50">Authorized Client</p>
                                <p class="text-white font-medium uppercase font-mono truncate max-w-[160px]">{{ $cust_name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-wider text-right text-white/50">Status</p>
                                <p class="text-emerald-300 font-medium font-mono">Available</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-2 flex items-center justify-between">
                        <span class="text-xs text-secondary font-medium">Physical & Virtual Issuance</span>
                        <a href="{{ url('request-card') }}" class="text-xs font-bold text-[#004226] hover:underline flex items-center gap-1">
                            <span>Order Card</span>
                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Designated Institutional Account Officer Card -->
            <div class="rounded-2xl bg-surface-container-lowest p-6 border border-outline-variant/30 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px] text-primary">support_agent</span>
                            <span class="font-heading font-bold text-sm text-on-surface">Institutional Officer</span>
                        </div>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" title="Desk Active"></span>
                    </div>

                    <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/20">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#004226] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                SJ
                            </div>
                            <div>
                                <p class="text-xs font-bold text-on-surface">Sarah Jenkins</p>
                                <p class="text-[11px] text-secondary">Senior Treasury Specialist</p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-surface-container space-y-1.5 text-xs text-secondary font-mono">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[15px] text-primary">call</span>
                                <span>+44 20 7946 0912</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[15px] text-primary">mail</span>
                                <span>s.jenkins@equitable.com</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 flex items-center justify-between border-t border-surface-container">
                    <a href="{{ url('send-message') }}" class="text-xs font-bold text-[#004226] hover:underline flex items-center gap-1">
                        <span>Message Desk</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                    <a href="{{ url('account-manager') }}" class="text-xs text-secondary hover:text-on-surface">
                        <span>Desk Hours</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Footer -->
@include('footer')

<script>
    function filterActivities(query) {
        const q = query.toLowerCase();
        const rows = document.querySelectorAll('.activity-row');
        rows.forEach(r => {
            const text = r.innerText.toLowerCase();
            r.style.display = text.includes(q) ? '' : 'none';
        });
    }
</script>
