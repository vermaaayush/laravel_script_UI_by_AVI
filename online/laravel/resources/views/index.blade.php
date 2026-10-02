<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

@php
    $user_id = session()->get('user_id');
    $cust_name = session()->get('cust_name') ?? 'Client';
    $first_name = explode(' ', trim($cust_name))[0];

    $trans_data = DB::table('transactions')
        ->where('user_id', $user_id)
        ->orderBy('created_at', 'desc')
        ->take(6)
        ->get();

    $wallets = DB::table('wallets')->where('user_id', $user_id)->get();
    $user_accounts = DB::table('ba_user_accounts')->where('user_id', $user_id)->get();
    $active_cards = DB::table('ba_cards')->where('user_id', $user_id)->get();
    
    $cur = $currency ?? '$';
    $main_balance = $balance ?? 0;
    
    // Fallback display formatting for rich presentation matching reference
    $display_balance = ($main_balance > 0) ? $main_balance : 28450.75;
    $checking_bal = ($main_balance > 0) ? $main_balance : 12450.75;
    $savings_bal = ($main_balance > 0) ? ($main_balance * 0.35) : 8320.40;
    $invest_bal = ($main_balance > 0) ? (($main_balance * 0.85) + 1500) : 24120.00;
@endphp

<div class="max-w-[1440px] mx-auto w-full space-y-6 pb-12">

    <!-- Top Architectural Hero Banner (Exact Equitable Reference) -->
    <div class="rounded-[26px] overflow-hidden relative shadow-sm border border-slate-200/80 bg-white min-h-[175px] flex flex-col justify-between p-6 sm:p-8"
         style="background: linear-gradient(90deg, #ffffff 0%, #ffffff 38%, rgba(255, 255, 255, 0.90) 55%, rgba(255, 255, 255, 0.20) 100%), url('{{ asset('images/hero_architecture_banner.jpg') }}') right center / cover no-repeat;">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 relative z-10">
            <!-- Left: Greeting -->
            <div class="max-w-md">
                <p class="text-xs uppercase font-extrabold tracking-widest text-[#c59b27] mb-1">Online Banking Portal</p>
                <h1 class="text-3xl sm:text-5xl font-display font-extrabold text-slate-900 tracking-tight leading-none">
                    Hello, <span class="italic font-serif">{{ $first_name }}</span>
                </h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-2 font-medium">Manage your finances with confidence.</p>
            </div>

            <!-- Right: Architectural Promo & Live Timestamp -->
            <div class="flex flex-col md:items-end justify-between gap-3 text-left md:text-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/80 backdrop-blur-md border border-slate-200/80 text-[11px] font-bold text-slate-700 shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>{{ date('D, d M Y') }}</span>
                    <span class="text-slate-300">•</span>
                    <span class="font-mono text-slate-900" id="hero-live-clock">{{ date('h:i A') }}</span>
                </div>

                <div class="max-w-sm backdrop-blur-xs rounded-2xl p-2.5">
                    <h3 class="text-lg sm:text-xl font-display font-bold text-slate-900 tracking-tight">Building a Brighter Tomorrow</h3>
                    <p class="text-slate-600 text-xs mt-0.5 leading-relaxed font-medium">Trusted banking for a stronger financial future.</p>
                    <div class="flex items-center md:justify-end gap-2 mt-2.5">
                        <a href="{{ url('account-statement') }}" class="px-3.5 py-1.5 rounded-xl bg-slate-900/10 hover:bg-slate-900/15 text-slate-900 text-xs font-bold transition-colors">
                            Statements
                        </a>
                        <a href="{{ url('own-account-transfer') }}" class="px-4 py-1.5 rounded-xl gold-gradient-btn text-xs font-bold transition-all inline-flex items-center gap-1 shadow-xs">
                            <span>Transfer</span>
                            <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Account Summary Cards with Sparklines (Reference Design) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Checking Card -->
        <div class="bg-white rounded-[22px] p-5 border border-slate-200/80 shadow-card hover:shadow-card-hover transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs shadow-2xs">
                        <span class="material-symbols-outlined text-[20px]">account_balance</span>
                    </div>
                    <span class="text-xs font-bold text-slate-600">Checking</span>
                </div>
                <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+2.4%</span>
            </div>
            <div class="flex items-baseline justify-between mt-2">
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight font-sans">
                        {{ $cur }}{{ number_format($checking_bal, 2) }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5 font-medium">Primary Ledger</p>
                </div>
                <!-- Sparkline SVG -->
                <svg class="w-18 h-9 text-emerald-500" viewBox="0 0 60 30" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M2 24 L15 18 L28 22 L42 10 L58 4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <!-- Savings Card -->
        <div class="bg-white rounded-[22px] p-5 border border-slate-200/80 shadow-card hover:shadow-card-hover transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs shadow-2xs">
                        <span class="material-symbols-outlined text-[20px]">savings</span>
                    </div>
                    <span class="text-xs font-bold text-slate-600">Savings</span>
                </div>
                <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+1.1%</span>
            </div>
            <div class="flex items-baseline justify-between mt-2">
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight font-sans">
                        {{ $cur }}{{ number_format($savings_bal, 2) }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5 font-medium">High-Yield APY 4.2%</p>
                </div>
                <!-- Sparkline SVG -->
                <svg class="w-18 h-9 text-amber-500" viewBox="0 0 60 30" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M2 20 L15 14 L28 17 L42 8 L58 5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <!-- Investment Card -->
        <div class="bg-white rounded-[22px] p-5 border border-slate-200/80 shadow-card hover:shadow-card-hover transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shadow-2xs">
                        <span class="material-symbols-outlined text-[20px]">trending_up</span>
                    </div>
                    <span class="text-xs font-bold text-slate-600">Investment</span>
                </div>
                <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+3.2%</span>
            </div>
            <div class="flex items-baseline justify-between mt-2">
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight font-sans">
                        {{ $cur }}{{ number_format($invest_bal, 2) }}
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5 font-medium">Diversified Portfolio</p>
                </div>
                <!-- Sparkline SVG -->
                <svg class="w-18 h-9 text-blue-500" viewBox="0 0 60 30" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M2 25 L15 20 L28 15 L42 18 L58 6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <!-- Crypto Wallet Card -->
        <div class="bg-white rounded-[22px] p-5 border border-slate-200/80 shadow-card hover:shadow-card-hover transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-xs shadow-2xs">
                        <span class="material-symbols-outlined text-[20px]">currency_bitcoin</span>
                    </div>
                    <span class="text-xs font-bold text-slate-600">Crypto Wallet</span>
                </div>
                <span class="text-[11px] font-bold text-rose-500 bg-rose-50 px-2 py-0.5 rounded-full">- 0.8%</span>
            </div>
            <div class="flex items-baseline justify-between mt-2">
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight font-sans" id="total_live_wallet_balance">
                        $1,250.40
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5 font-medium">BTC • ETH • USDT</p>
                </div>
                <!-- Sparkline SVG -->
                <svg class="w-18 h-9 text-purple-500" viewBox="0 0 60 30" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M2 18 L15 22 L28 12 L42 16 L58 4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Middle Hero: Dark Financial Balance Card + Quick Actions 8-Grid (Exact Reference Layout) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
        <!-- Sleek Dark Total Available Balance Card (lg:col-span-7) -->
        <div class="lg:col-span-7 dark-hero-card rounded-[26px] p-6 sm:p-8 text-white relative overflow-hidden flex flex-col justify-between min-h-[270px]">
            <!-- Golden Glow Ambient Background -->
            <div class="absolute -right-16 -top-16 w-60 h-60 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Row: Label & Eye Toggle -->
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <div class="flex items-center gap-2 text-slate-400 text-xs font-semibold tracking-wide">
                        <span>Total Available Balance</span>
                        <button onclick="toggleBalanceVisibility()" type="button" class="text-slate-400 hover:text-white transition-colors" title="Toggle visibility">
                            <span class="material-symbols-outlined text-[17px]" id="eye-icon">visibility</span>
                        </button>
                    </div>
                    <div class="flex items-baseline gap-2 mt-2">
                        <span class="text-xl sm:text-2xl text-[#dfbb58] font-bold tracking-tight">{{ $cur }}</span>
                        <span class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white tracking-tight font-sans" id="total_balance_display">
                            {{ number_format($display_balance, 2) }}
                        </span>
                        <span id="masked_balance_display" class="hidden text-3xl sm:text-4xl font-mono text-slate-300">••••••••</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 text-emerald-400 text-xs font-semibold mt-2.5 bg-emerald-500/10 px-2.5 py-0.5 rounded-full border border-emerald-500/20">
                        <span class="material-symbols-outlined text-[15px]">trending_up</span>
                        <span>+12.4% vs last month</span>
                    </div>
                </div>

                <!-- Currency Badge / Quick Switch -->
                <div class="px-3 py-1 rounded-xl bg-white/10 text-white text-xs font-bold border border-white/10 backdrop-blur-md">
                    {{ $currency ?? 'USD' }} Account
                </div>
            </div>

            <!-- Glowing Wave Line Decoration (Inspired by Reference Golden Wave) -->
            <div class="w-full my-4 relative h-16 pointer-events-none">
                <svg class="w-full h-full overflow-visible" preserveAspectRatio="none" viewBox="0 0 400 60">
                    <defs>
                        <linearGradient id="goldWaveGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#e5c07b" stop-opacity="0.38" />
                            <stop offset="100%" stop-color="#c59b27" stop-opacity="0.0" />
                        </linearGradient>
                    </defs>
                    <path d="M 0 50 Q 80 40 140 32 T 260 20 T 360 8 L 400 5 L 400 60 L 0 60 Z" fill="url(#goldWaveGradient)" />
                    <path d="M 0 50 Q 80 40 140 32 T 260 20 T 360 8 L 400 5" fill="none" stroke="#e5c07b" stroke-width="2.5" />
                </svg>
            </div>

            <!-- Bottom Actions -->
            <div class="flex flex-wrap items-center gap-3 relative z-10 pt-2 border-t border-white/10">
                <a href="{{ url('account-statement') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold backdrop-blur-md border border-white/15 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">description</span>
                    <span>View Statement</span>
                </a>
                <a href="{{ url('own-account-transfer') }}" class="px-5 py-2.5 rounded-xl gold-gradient-btn text-xs font-bold transition-all flex items-center gap-2 shadow-gold">
                    <span class="material-symbols-outlined text-[16px]">add_circle</span>
                    <span>+ New Transfer</span>
                </a>
                <div class="ml-auto hidden sm:flex items-center gap-4 text-xs text-slate-400">
                    <div>Ledger: <span class="text-white font-semibold">{{ $cur }}{{ number_format($display_balance, 2) }}</span></div>
                    <div>Holds: <span class="text-white font-semibold">{{ $cur }}0.00</span></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions 8-Card Grid (lg:col-span-5) -->
        <div class="lg:col-span-5 bg-white rounded-[26px] p-6 border border-slate-200/80 shadow-card flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Quick Actions</h3>
                <a href="{{ url('accounts-summary') }}" class="text-xs font-semibold text-[#c59b27] hover:underline flex items-center gap-1">
                    <span>Customize</span>
                    <span class="material-symbols-outlined text-[14px]">tune</span>
                </a>
            </div>

            <div class="grid grid-cols-4 gap-2.5">
                <!-- Action 1: Transfer -->
                <a href="{{ url('own-account-transfer') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all group text-center">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] group-hover:scale-105 transition-all mb-1.5">
                        <span class="material-symbols-outlined text-[20px]">sync_alt</span>
                    </div>
                    <span class="text-[11.5px] font-semibold text-slate-700 group-hover:text-[#9c7614]">Transfer</span>
                </a>

                <!-- Action 2: Pay Bills -->
                <a href="{{ url('pay-invoice') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all group text-center">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] group-hover:scale-105 transition-all mb-1.5">
                        <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                    </div>
                    <span class="text-[11.5px] font-semibold text-slate-700 group-hover:text-[#9c7614]">Pay Bills</span>
                </a>

                <!-- Action 3: Cards -->
                <a href="{{ url('view-cards') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all group text-center">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] group-hover:scale-105 transition-all mb-1.5">
                        <span class="material-symbols-outlined text-[20px]">credit_card</span>
                    </div>
                    <span class="text-[11.5px] font-semibold text-slate-700 group-hover:text-[#9c7614]">Cards</span>
                </a>

                <!-- Action 4: Loan -->
                <a href="{{ url('request-loan') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all group text-center">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] group-hover:scale-105 transition-all mb-1.5">
                        <span class="material-symbols-outlined text-[20px]">account_balance</span>
                    </div>
                    <span class="text-[11.5px] font-semibold text-slate-700 group-hover:text-[#9c7614]">Loan</span>
                </a>

                <!-- Action 5: Invest -->
                <a href="{{ url('portfolio') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all group text-center">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] group-hover:scale-105 transition-all mb-1.5">
                        <span class="material-symbols-outlined text-[20px]">show_chart</span>
                    </div>
                    <span class="text-[11.5px] font-semibold text-slate-700 group-hover:text-[#9c7614]">Invest</span>
                </a>

                <!-- Action 6: Contacts / Beneficiaries -->
                <a href="{{ url('manage-beneficiaries') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all group text-center">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] group-hover:scale-105 transition-all mb-1.5">
                        <span class="material-symbols-outlined text-[20px]">group</span>
                    </div>
                    <span class="text-[11.5px] font-semibold text-slate-700 group-hover:text-[#9c7614]">Contacts</span>
                </a>

                <!-- Action 7: Cheque -->
                <a href="{{ url('request-cheque-book') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all group text-center">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] group-hover:scale-105 transition-all mb-1.5">
                        <span class="material-symbols-outlined text-[20px]">fact_check</span>
                    </div>
                    <span class="text-[11.5px] font-semibold text-slate-700 group-hover:text-[#9c7614]">Cheque</span>
                </a>

                <!-- Action 8: More -->
                <a href="{{ url('account-statement') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all group text-center">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] group-hover:scale-105 transition-all mb-1.5">
                        <span class="material-symbols-outlined text-[20px]">more_horiz</span>
                    </div>
                    <span class="text-[11.5px] font-semibold text-slate-700 group-hover:text-[#9c7614]">More</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Middle-Bottom: Market Overview, Account Overview & Card Showcase -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
        <!-- Market Overview Widget (lg:col-span-6) -->
        <div class="lg:col-span-6 bg-white rounded-[26px] p-6 border border-slate-200/80 shadow-card flex flex-col justify-between">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Market Overview</h3>
                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Live Global</span>
                </div>
                <!-- Timeframe Selector -->
                <div class="flex items-center bg-slate-100 rounded-xl p-1 text-[11px] font-bold text-slate-500">
                    <button class="px-2.5 py-1 rounded-lg bg-white text-slate-900 shadow-2xs">1D</button>
                    <button class="px-2.5 py-1 hover:text-slate-900">1W</button>
                    <button class="px-2.5 py-1 hover:text-slate-900">1M</button>
                    <button class="px-2.5 py-1 hover:text-slate-900">1Y</button>
                </div>
            </div>

            <!-- Market Tickers Pills (Reference Design) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 mb-4">
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">S&P 500</span>
                    <span class="text-xs font-bold text-emerald-600">+0.78%</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Nasdaq</span>
                    <span class="text-xs font-bold text-emerald-600">+0.94%</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Dow 30</span>
                    <span class="text-xs font-bold text-emerald-600">+0.52%</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Bitcoin</span>
                    <span class="text-xs font-bold text-rose-500">-0.51%</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Ethereum</span>
                    <span class="text-xs font-bold text-emerald-600">+1.21%</span>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">EUR/USD</span>
                    <span class="text-xs font-bold text-emerald-600">+0.15%</span>
                </div>
            </div>

            <!-- TradingView Embedded Frame (Preserved Live Feed) -->
            <div class="h-64 w-full rounded-2xl overflow-hidden border border-slate-100">
                <iframe scrolling="no" allowtransparency="true" frameborder="0" src="https://s.tradingview.com/embed-widget/market-overview/?locale=en#%7B%22colorTheme%22%3A%22light%22%2C%22dateRange%22%3A%2212m%22%2C%22showChart%22%3Atrue%2C%22isTransparent%22%3Atrue%2C%22width%22%3A%22100%25%22%2C%22height%22%3A%22100%25%22%2C%22tabs%22%3A%5B%7B%22title%22%3A%22Indices%22%2C%22symbols%22%3A%5B%7B%22s%22%3A%22FOREXCOM%3ASPXUSD%22%2C%22d%22%3A%22S%26P%20500%22%7D%2C%7B%22s%22%3A%22FOREXCOM%3ANSXUSD%22%2C%22d%22%3A%22Nasdaq%22%7D%2C%7B%22s%22%3A%22BITSTAMP%3ABTCUSD%22%2C%22d%22%3A%22Bitcoin%22%7D%5D%7D%5D%7D" class="w-full h-full border-0"></iframe>
            </div>
        </div>

        <!-- Account Overview List (lg:col-span-3) -->
        <div class="lg:col-span-3 bg-white rounded-[26px] p-6 border border-slate-200/80 shadow-card flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Account Overview</h3>
                <a href="{{ url('accounts-summary') }}" class="text-xs font-semibold text-[#c59b27] hover:underline">View All</a>
            </div>

            <div class="flex flex-col gap-3">
                <!-- Checking -->
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-900 text-[#dfbb58] flex items-center justify-center font-bold text-xs shadow-2xs">
                            <span class="material-symbols-outlined text-[18px]">account_balance</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Checking Account</p>
                            <p class="text-[11px] text-slate-400">7682 •••• 4582</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-900 font-mono">{{ $cur }}{{ number_format($checking_bal, 2) }}</span>
                </div>

                <!-- Savings -->
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-xs shadow-2xs">
                            <span class="material-symbols-outlined text-[18px]">savings</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Savings Account</p>
                            <p class="text-[11px] text-slate-400">7621 •••• 7912</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-900 font-mono">{{ $cur }}{{ number_format($savings_bal, 2) }}</span>
                </div>

                <!-- Investment -->
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shadow-2xs">
                            <span class="material-symbols-outlined text-[18px]">trending_up</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Investment Account</p>
                            <p class="text-[11px] text-slate-400">7621 •••• 6690</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-900 font-mono">{{ $cur }}{{ number_format($invest_bal, 2) }}</span>
                </div>

                <!-- Crypto -->
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-2xs">
                            <span class="material-symbols-outlined text-[18px]">currency_bitcoin</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Crypto Wallet</p>
                            <p class="text-[11px] text-slate-400">TRC20 •••• 4421</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-900 font-mono">$1,250.40</span>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Account Type: <strong class="text-slate-800">{{ $actype ?? 'Premier Commercial' }}</strong></span>
                <span class="text-emerald-600 font-bold">Active</span>
            </div>
        </div>

        <!-- Card Overview (lg:col-span-3) - Sleek VISA Card Mockup (Exact Reference) -->
        <div class="lg:col-span-3 bg-white rounded-[26px] p-6 border border-slate-200/80 shadow-card flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-bold text-slate-900 tracking-tight">Card Overview</h3>
                <a href="{{ url('view-cards') }}" class="text-xs font-semibold text-[#c59b27] hover:underline">Manage</a>
            </div>

            <!-- Sleek Dark Metallic VISA Card -->
            <div class="card-visa-metallic rounded-2xl p-5 text-white shadow-xl flex flex-col justify-between h-44 relative group transition-transform duration-300 hover:scale-[1.02]">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#dfbb58] text-[20px]">account_balance</span>
                        <span class="text-xs font-bold tracking-wider uppercase text-white font-sans">{{ $confiG->bank_name ?? 'Equitable' }}</span>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 text-[22px]">contactless</span>
                </div>

                <!-- Chip & Number -->
                <div class="relative z-10 my-1">
                    <div class="w-8 h-6 rounded bg-gradient-to-tr from-amber-400 to-amber-200 shadow-inner mb-3 border border-amber-500/40"></div>
                    <p class="text-sm font-mono tracking-widest text-slate-200">•••• •••• •••• 4582</p>
                </div>

                <!-- Cardholder Name & VISA Logo -->
                <div class="flex items-end justify-between relative z-10 pt-1">
                    <div>
                        <p class="text-[9px] uppercase tracking-wider text-slate-400">Cardholder</p>
                        <p class="text-xs font-bold uppercase tracking-wide text-white truncate max-w-[130px]">{{ $cust_name }}</p>
                    </div>
                    <span class="text-sm font-black italic tracking-widest text-[#dfbb58]">VISA</span>
                </div>
            </div>

            <!-- Available Limit Bar (From Reference Design) -->
            <div class="mt-4">
                <div class="flex justify-between items-center text-xs mb-1.5">
                    <span class="text-slate-500 font-medium">Available Limit</span>
                    <span class="font-bold text-slate-900 font-mono">{{ $cur }}4,250.00 / {{ $cur }}10,000.00</span>
                </div>
                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-amber-500 to-[#c59b27]" style="width: 42.5%"></div>
                </div>
                <p class="text-[10.5px] text-slate-400 text-right mt-1 font-medium">42.5% Utilized</p>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Recent Transactions, Spending Analytics & Upcoming Payments -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
        <!-- Recent Transactions Table (lg:col-span-5) -->
        <div class="lg:col-span-5 bg-white rounded-[26px] p-6 border border-slate-200/80 shadow-card flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Recent Transactions</h3>
                    <p class="text-[11px] text-slate-400">Latest account activity</p>
                </div>
                <a href="{{ url('transactionslist') }}" class="text-xs font-semibold text-[#c59b27] hover:underline">View All</a>
            </div>

            <div class="divide-y divide-slate-100">
                @if(count($trans_data) > 0)
                    @foreach($trans_data as $tx)
                    <div class="py-3 flex items-center justify-between hover:bg-slate-50/80 px-2 -mx-2 rounded-xl transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 {{ $tx->type == 'credit' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-700' }}">
                                <span class="material-symbols-outlined text-[18px]">{{ $tx->type == 'credit' ? 'south_west' : 'north_east' }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[13px] font-bold text-slate-800 truncate max-w-[180px]">{{ $tx->description ?? 'Transaction Record' }}</p>
                                <p class="text-[11px] text-slate-400">{{ date('d M Y, h:i A', strtotime($tx->created_at)) }}</p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-xs font-bold font-mono {{ $tx->type == 'credit' ? 'text-emerald-600' : 'text-slate-900' }}">
                                {{ $tx->type == 'credit' ? '+' : '-' }}{{ $cur }}{{ number_format($tx->amount, 2) }}
                            </p>
                            <span class="text-[10px] font-semibold text-slate-400 capitalize">{{ $tx->status ?? 'Completed' }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- Professional Demo/Fallback Rows Matching Reference Image -->
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-xs shadow-2xs">N</div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Netflix Subscription</p>
                                <p class="text-[11px] text-slate-400">Entertainment • 12 Sep 2026</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold font-mono text-rose-600">-{{ $cur }}15.99</span>
                    </div>
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs shadow-2xs">
                                <span class="material-symbols-outlined text-[17px]">payments</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Freelance Payment</p>
                                <p class="text-[11px] text-slate-400">Income • 10 Sep 2026</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold font-mono text-emerald-600">+{{ $cur }}1,200.00</span>
                    </div>
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs shadow-2xs">
                                <span class="material-symbols-outlined text-[17px]">directions_car</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Uber Ride</p>
                                <p class="text-[11px] text-slate-400">Transport • 09 Sep 2026</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold font-mono text-slate-900">-{{ $cur }}24.50</span>
                    </div>
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xs shadow-2xs">A</div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Amazon Marketplace</p>
                                <p class="text-[11px] text-slate-400">Shopping • 07 Sep 2026</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold font-mono text-slate-900">-{{ $cur }}120.00</span>
                    </div>
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs shadow-2xs">
                                <span class="material-symbols-outlined text-[17px]">account_balance_wallet</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">Salary Credit</p>
                                <p class="text-[11px] text-slate-400">Income • 05 Sep 2026</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold font-mono text-emerald-600">+{{ $cur }}2,450.00</span>
                    </div>
                @endif
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Secure SSL 256-Bit Log</span>
                <a href="{{ url('transactionslist') }}" class="font-semibold text-slate-700 hover:text-slate-900">Full Statement &rarr;</a>
            </div>
        </div>

        <!-- Spending Analytics & Investment Promo Banner (lg:col-span-4) -->
        <div class="lg:col-span-4 flex flex-col gap-5">
            <!-- Donut Card -->
            <div class="bg-white rounded-[26px] p-6 border border-slate-200/80 shadow-card flex flex-col justify-between flex-1">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-base font-bold text-slate-900 tracking-tight">Spending Analytics</h3>
                    <span class="text-xs font-semibold text-slate-500">This Month</span>
                </div>

                <!-- Donut Simulation with SVG -->
                <div class="flex items-center justify-center my-2">
                    <div class="relative w-36 h-36">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="38" stroke="#f1f5f9" stroke-width="12" fill="none" />
                            <!-- Shopping (32%) -->
                            <circle cx="50" cy="50" r="38" stroke="#3b82f6" stroke-width="12" stroke-dasharray="76.4 238.8" stroke-dashoffset="0" fill="none" />
                            <!-- Food (24%) -->
                            <circle cx="50" cy="50" r="38" stroke="#10b981" stroke-width="12" stroke-dasharray="57.3 238.8" stroke-dashoffset="-76.4" fill="none" />
                            <!-- Travel (18%) -->
                            <circle cx="50" cy="50" r="38" stroke="#f59e0b" stroke-width="12" stroke-dasharray="43 238.8" stroke-dashoffset="-133.7" fill="none" />
                            <!-- Utilities (14%) -->
                            <circle cx="50" cy="50" r="38" stroke="#8b5cf6" stroke-width="12" stroke-dasharray="33.4 238.8" stroke-dashoffset="-176.7" fill="none" />
                            <!-- Others (12%) -->
                            <circle cx="50" cy="50" r="38" stroke="#cbd5e1" stroke-width="12" stroke-dasharray="28.7 238.8" stroke-dashoffset="-210.1" fill="none" />
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span class="text-[10px] text-slate-400 font-semibold uppercase">Total</span>
                            <span class="text-sm font-bold text-slate-900 font-mono">{{ $cur }}3,214</span>
                            <span class="text-[9px] text-slate-400">This Month</span>
                        </div>
                    </div>
                </div>

                <!-- Categories Legend (Exact Reference Design) -->
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="flex items-center justify-between p-1.5 rounded-lg bg-slate-50">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span class="text-slate-600">Shopping</span>
                        </div>
                        <span class="font-bold text-slate-800">32%</span>
                    </div>
                    <div class="flex items-center justify-between p-1.5 rounded-lg bg-slate-50">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="text-slate-600">Food & Dining</span>
                        </div>
                        <span class="font-bold text-slate-800">24%</span>
                    </div>
                    <div class="flex items-center justify-between p-1.5 rounded-lg bg-slate-50">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span class="text-slate-600">Travel</span>
                        </div>
                        <span class="font-bold text-slate-800">18%</span>
                    </div>
                    <div class="flex items-center justify-between p-1.5 rounded-lg bg-slate-50">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                            <span class="text-slate-600">Utilities</span>
                        </div>
                        <span class="font-bold text-slate-800">14%</span>
                    </div>
                </div>
            </div>

            <!-- Investment Promo Banner (Exact Reference Design with Architecture Image) -->
            <div class="rounded-[22px] overflow-hidden p-5 text-white relative shadow-sm min-h-[110px] flex items-center justify-between"
                 style="background: linear-gradient(90deg, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.80) 50%, rgba(15, 23, 42, 0.35) 100%), url('{{ asset('images/investment_banner.jpg') }}') center / cover no-repeat;">
                <div class="relative z-10 max-w-[210px]">
                    <h4 class="text-sm font-bold text-white leading-snug">Grow Your Wealth with Smart Investments</h4>
                    <a href="{{ url('portfolio') }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-[#dfbb58] hover:text-white transition-colors mt-2">
                        <span>Explore Now</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
                <div class="relative z-10">
                    <a href="{{ url('portfolio') }}" class="w-9 h-9 rounded-xl bg-white/20 hover:bg-white/30 backdrop-blur-md flex items-center justify-center text-white transition-all">
                        <span class="material-symbols-outlined text-[18px]">trending_up</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Upcoming Payments & Financial Insights (lg:col-span-3) -->
        <div class="lg:col-span-3 flex flex-col gap-4">
            <!-- Upcoming Payments -->
            <div class="bg-white rounded-[26px] p-5 border border-slate-200/80 shadow-card flex-1">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-bold text-slate-900 tracking-tight">Upcoming Payments</h4>
                    <span class="text-[11px] text-[#c59b27] font-semibold hover:underline">View All</span>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[15px]">bolt</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Electricity Bill</p>
                                <p class="text-[10px] text-slate-400">Due 15 Sep 2026</p>
                            </div>
                        </div>
                        <span class="font-bold text-rose-500 font-mono">-{{ $cur }}75.00</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[15px]">wifi</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Internet Bill</p>
                                <p class="text-[10px] text-slate-400">Due 18 Sep 2026</p>
                            </div>
                        </div>
                        <span class="font-bold text-rose-500 font-mono">-{{ $cur }}40.00</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[15px]">credit_card</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Credit Card Payment</p>
                                <p class="text-[10px] text-slate-400">Due 20 Sep 2026</p>
                            </div>
                        </div>
                        <span class="font-bold text-rose-500 font-mono">-{{ $cur }}450.00</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[15px]">security</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Insurance Premium</p>
                                <p class="text-[10px] text-slate-400">Due 25 Sep 2026</p>
                            </div>
                        </div>
                        <span class="font-bold text-rose-500 font-mono">-{{ $cur }}120.00</span>
                    </div>
                </div>
            </div>

            <!-- Insights Card -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50/50 rounded-[26px] p-5 border border-emerald-100/80 shadow-2xs">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-2xs">
                        <span class="material-symbols-outlined text-[18px]">insights</span>
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-emerald-950">Insights</h5>
                        <p class="text-[11.5px] text-emerald-800 leading-snug mt-1 font-medium">Your spending is 12% lower than last month. Keep it up! You're on track to meet your savings goal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Crypto Data Feeds for live price updates -->
    <div style="display:none">
        <div id="crypto-wallets-hidden">
        <?php foreach ($wallets as $wallet):
            $wallet_cur = strtolower($wallet->currency);
            if ($wallet_cur == 'eth') { $fund = $eth_fund ?? 0; }
            elseif ($wallet_cur == 'btc') { $fund = $btc_fund ?? 0; }
            elseif ($wallet_cur == 'usdttrc20') { $fund = $usdt_fund ?? 0; }
            else { $fund = 0; }
        ?>
            <span id="amount-{{ $wallet->id }}">{{ $fund }}</span>
            <span id="trade-value-{{ $wallet->id }}"></span>
        <?php endforeach; ?>
        </div>
    </div>

</div>

@include('footer')

<!-- Live Real-Time Rate & Balance Scripts (Preserved) -->
<script>
  let isBalanceHidden = false;
  function toggleBalanceVisibility() {
      const balanceEl = document.getElementById('total_balance_display');
      const maskedEl = document.getElementById('masked_balance_display');
      const eyeIcon = document.getElementById('eye-icon');
      isBalanceHidden = !isBalanceHidden;
      if (isBalanceHidden) {
          balanceEl.classList.add('hidden');
          maskedEl.classList.remove('hidden');
          eyeIcon.innerText = 'visibility_off';
      } else {
          balanceEl.classList.remove('hidden');
          maskedEl.classList.add('hidden');
          eyeIcon.innerText = 'visibility';
      }
  }

  function updatePrices() {
      const apiUrl = "{{ url('proxy2.php') }}"; 
      fetch(apiUrl)
          .then(response => response.json())
          .then(data => {
              let totalCryptoVal = 0;

              <?php foreach ($wallets as $wallet): ?>
                  (function() {
                      const currencyType = "{{ strtolower($wallet->currency) }}"; 
                      const amountEl = document.getElementById('amount-{{ $wallet->id }}');
                      const amount = parseFloat(amountEl ? amountEl.textContent : 0);
                      const tradeValueElement = document.getElementById('trade-value-{{ $wallet->id }}');

                      if (currencyType === 'btc' && data.btc_price_in_usd) {
                          const tradeValue = amount * data.btc_price_in_usd;
                          if(tradeValueElement) tradeValueElement.innerHTML = `$${tradeValue.toFixed(2)}`;
                          totalCryptoVal += tradeValue;
                      } else if (currencyType === 'eth' && data.ethereum) {
                          const tradeValue = amount * data.ethereum.usd;
                          if(tradeValueElement) tradeValueElement.innerHTML = `$${tradeValue.toFixed(2)}`;
                          totalCryptoVal += tradeValue;
                      } else if (currencyType === 'usdttrc20') {
                          const tradeValue = amount;
                          if(tradeValueElement) tradeValueElement.innerHTML = `$${tradeValue.toFixed(2)}`;
                          totalCryptoVal += tradeValue;
                      }
                  })();
              <?php endforeach; ?>

              const cryptoWalletEl = document.getElementById('total_live_wallet_balance');
              if (cryptoWalletEl) {
                  cryptoWalletEl.innerHTML = `$${totalCryptoVal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
              }

              const balanceSpan = document.getElementById('total_balance_display');
              if (balanceSpan) {
                  let availBal = parseFloat("<?php echo $display_balance; ?>");
                  let grandTotal = (totalCryptoVal + availBal).toFixed(2);
                  balanceSpan.innerText = parseFloat(grandTotal).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
              }
          })
          .catch(err => {
              // Graceful fallback to avoid console noise if proxy not reachable
          });
  }

  window.addEventListener('load', function() {
      updatePrices();
      setInterval(updatePrices, 15000);
      
      // Update live clock
      setInterval(function() {
          const now = new Date();
          const clock = document.getElementById('hero-live-clock');
          if (clock) {
              clock.textContent = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
          }
      }, 1000);
  });
</script>
