<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

@php
    $txs = $transactions ?? [];
    if(empty($txs) && Session::has('user_id')) {
        $txs = DB::select('select * from ba_transactions where user_id = ? order by datetime desc', [Session::get('user_id')]);
    }
    $accs = $accounts ?? [];
    if(empty($accs) && Session::has('user_id')) {
        $accs = DB::select('select * from ba_user_accounts where user_id = ?', [Session::get('user_id')]);
    }

    $currencySymbol = '$';
    $totalAvailable = 0;
    foreach($accs as $acc) {
        if(!empty($acc->account_currency)) {
            $currencySymbol = $acc->account_currency;
        }
        $totalAvailable += (float)($acc->available_balance ?? 0);
    }

    $grossOutflow = 0;
    $grossInflow = 0;
    $totalCharges = 0;
    $debitTxCount = 0;
    $creditTxCount = 0;
    $chargesCount = 0;

    $categories = [
        'Transfers & Dispatches' => ['amount' => 0, 'count' => 0, 'color' => '#004226', 'icon' => 'payments'],
        'Cross-Border Settlements' => ['amount' => 0, 'count' => 0, 'color' => '#0f5b38', 'icon' => 'currency_exchange'],
        'Operational & Service Charges' => ['amount' => 0, 'count' => 0, 'color' => '#2b7a4b', 'icon' => 'receipt_long'],
        'Account Maintenance & Misc' => ['amount' => 0, 'count' => 0, 'color' => '#53625b', 'icon' => 'swap_horiz'],
    ];

    $monthlyOutflow = [];
    $recentOutbound = [];
    $minDate = null;
    $maxDate = null;

    foreach($txs as $t) {
        $amt = (float)($t->amount ?? 0);
        $type = strtolower($t->type ?? '');
        $ts = !empty($t->datetime) ? strtotime($t->datetime) : time();
        if(!$minDate || $ts < $minDate) $minDate = $ts;
        if(!$maxDate || $ts > $maxDate) $maxDate = $ts;

        $monthKey = date('M Y', $ts);

        if($type == 'credited' || $type == 'credit') {
            $grossInflow += $amt;
            $creditTxCount++;
        } elseif($type == 'debited' || $type == 'debit') {
            $grossOutflow += $amt;
            $debitTxCount++;
            $monthlyOutflow[$monthKey] = ($monthlyOutflow[$monthKey] ?? 0) + $amt;
            $recentOutbound[] = $t;

            // Categorize by international or reason
            if(($t->international ?? 0) == 1 || strpos(strtolower($t->reason ?? ''), 'wire') !== false) {
                $categories['Cross-Border Settlements']['amount'] += $amt;
                $categories['Cross-Border Settlements']['count']++;
            } else {
                $categories['Transfers & Dispatches']['amount'] += $amt;
                $categories['Transfers & Dispatches']['count']++;
            }
        } elseif($type == 'charges' || $type == 'charge') {
            $grossOutflow += $amt;
            $totalCharges += $amt;
            $chargesCount++;
            $monthlyOutflow[$monthKey] = ($monthlyOutflow[$monthKey] ?? 0) + $amt;
            $recentOutbound[] = $t;

            $categories['Operational & Service Charges']['amount'] += $amt;
            $categories['Operational & Service Charges']['count']++;
        }
    }

    // Top dominant channel
    $dominantCategory = 'Transfers & Dispatches';
    $dominantAmount = 0;
    $dominantCount = 0;
    foreach($categories as $catName => $catData) {
        if($catData['amount'] > $dominantAmount) {
            $dominantAmount = $catData['amount'];
            $dominantCategory = $catName;
            $dominantCount = $catData['count'];
        }
    }
    $dominantPct = $grossOutflow > 0 ? round(($dominantAmount / $grossOutflow) * 100, 1) : 0;

    // Daily velocity
    $daysSpan = ($minDate && $maxDate && $maxDate > $minDate) ? max(1, round(($maxDate - $minDate) / 86400)) : 1;
    $dailyVelocity = $grossOutflow > 0 ? round($grossOutflow / $daysSpan, 2) : 0;

    // Capital Retention / Liquidity Cushion
    $totalTurnover = $grossInflow + $grossOutflow;
    $retentionRatio = ($totalTurnover + $totalAvailable) > 0 ? round(($totalAvailable / ($totalTurnover + $totalAvailable)) * 100, 1) : 100;
    if($retentionRatio > 100) $retentionRatio = 100;

    // Monthly chart bars (5-month rolling window ending on latest transaction month)
    $latestTs = $maxDate ?: time();
    $chartMonths = [];
    for($i = 4; $i >= 0; $i--) {
        $mKey = date('M Y', strtotime("-$i months", $latestTs));
        $chartMonths[$mKey] = $monthlyOutflow[$mKey] ?? 0;
    }
    $maxMonthly = max(array_values($chartMonths) ?: [1]);
    if($maxMonthly <= 0) $maxMonthly = 1;
    $activeMonthsCount = count(array_filter($chartMonths, function($v) { return $v > 0; }));
    $avgMonthly = $activeMonthsCount > 0 ? round(array_sum($chartMonths) / $activeMonthsCount, 2) : 0;
@endphp

<!-- Main Content Wrapper -->
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 space-y-6 font-sans">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-2 border-b border-surface-container">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-1">
                <a class="hover:text-[#004226] transition-colors" href="{{ url('/') }}">Custody Portal</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#191c1c] font-bold">Analytics & Treasury</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-heading text-[#191c1c] tracking-tight">Spending & Cashflow Intelligence</h1>
            <p class="text-xs sm:text-sm text-[#53625b] mt-1">Real-time dynamic breakdown of your account debits, charges, and settlement volumes.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ url('account-statement') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white hover:bg-[#f8faf9] text-[#191c1c] text-xs font-semibold border border-[#e6e9e8] shadow-sm transition-all">
                <span class="material-symbols-outlined text-[16px] text-[#53625b]">download</span>
                <span>Export Statement</span>
            </a>
            <a href="{{ url('transactionslist') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-[#004226] hover:bg-[#085232] text-white text-xs font-bold shadow-sm transition-all">
                <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                <span>All Transactions</span>
            </a>
        </div>
    </div>

    <!-- Analytics Dashboard Bento Cards (100% Dynamic) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Card 1: Gross Outbound Flow -->
        <div class="bg-white rounded-2xl p-5 border border-[#e6e9e8] shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#53625b] uppercase tracking-wider">Gross Outbound Flow</span>
                    <span class="text-[11px] font-bold text-[#004226] bg-[#eaf4ee] px-2 py-0.5 rounded-full border border-[#c4e3cf]">
                        {{ $debitTxCount + $chargesCount }} Outbound Txs
                    </span>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl sm:text-3xl font-mono font-bold text-[#191c1c] tracking-tight">
                        {{ $currencySymbol }} {{ number_format($grossOutflow, 2) }}
                    </span>
                </div>
                <p class="text-xs text-[#53625b] mt-1 font-mono">
                    {{ $chargesCount > 0 ? "Includes $currencySymbol " . number_format($totalCharges, 2) . " charges" : "Total debits processed" }}
                </p>
            </div>
            <div class="mt-4 pt-3 border-t border-[#f2f4f3] flex items-center justify-between text-xs text-[#53625b]">
                <span>Inflow Ratio:</span>
                <span class="font-mono font-bold text-[#004226]">
                    +{{ $currencySymbol }} {{ number_format($grossInflow, 2) }} ({{ $creditTxCount }} credits)
                </span>
            </div>
        </div>

        <!-- Card 2: Highest Expense Category -->
        <div class="bg-white rounded-2xl p-5 border border-[#e6e9e8] shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#53625b] uppercase tracking-wider">Dominant Ledger Channel</span>
                    <span class="text-[11px] font-bold text-[#004226] bg-[#eaf4ee] px-2 py-0.5 rounded-full border border-[#c4e3cf]">
                        {{ $dominantPct }}% of Outflows
                    </span>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-xl sm:text-2xl font-bold font-heading text-[#191c1c] tracking-tight">
                        {{ $dominantCategory }}
                    </span>
                </div>
                <p class="text-xs text-[#53625b] mt-1">
                    Volume: <strong class="font-mono text-[#191c1c]">{{ $currencySymbol }} {{ number_format($dominantAmount, 2) }}</strong> across {{ $dominantCount }} transactions
                </p>
            </div>
            <div class="w-full h-1.5 rounded-full bg-[#f2f4f3] overflow-hidden mt-4">
                <div class="h-full bg-[#004226] rounded-full transition-all" style="width: {{ max($dominantPct, 5) }}%"></div>
            </div>
        </div>

        <!-- Card 3: Capital Retention Ratio -->
        <div class="bg-white rounded-2xl p-5 border border-[#e6e9e8] shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[11px] font-bold text-[#53625b] uppercase tracking-wider">Capital Retention Ratio</span>
                    <span class="text-[11px] font-bold text-[#004226] bg-[#eaf4ee] px-2 py-0.5 rounded-full border border-[#c4e3cf]">
                        Available: {{ $currencySymbol }} {{ number_format($totalAvailable, 2) }}
                    </span>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl sm:text-3xl font-mono font-bold text-[#191c1c] tracking-tight">
                        {{ $retentionRatio }}%
                    </span>
                </div>
                <p class="text-xs text-[#53625b] mt-1">
                    Based on available ledger balance vs total transaction volume
                </p>
            </div>
            <div class="w-full h-1.5 rounded-full bg-[#f2f4f3] overflow-hidden mt-4">
                <div class="h-full bg-[#004226] rounded-full transition-all" style="width: {{ $retentionRatio }}%"></div>
            </div>
        </div>
    </div>

    <!-- Middle Grid: Dynamic Category Breakdown + Monthly Outflow Bar Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Category Breakdown (100% Dynamic from User Transactions) -->
        <div class="lg:col-span-6 bg-white rounded-2xl p-6 border border-[#e6e9e8] shadow-sm space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-base font-bold font-heading text-[#191c1c] tracking-tight">Disbursement Category Distribution</h3>
                    <span class="text-xs text-[#53625b] font-medium">{{ count($recentOutbound) }} Total Debits</span>
                </div>

                <div class="space-y-4 pt-1">
                    @php $hasCategories = false; @endphp
                    @foreach($categories as $catName => $catData)
                        @php
                            $catAmt = (float)$catData['amount'];
                            $pct = $grossOutflow > 0 ? round(($catAmt / $grossOutflow) * 100, 1) : 0;
                            if($catAmt > 0) $hasCategories = true;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center text-xs mb-1.5">
                                <span class="font-semibold text-[#191c1c] flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $catData['color'] }};"></span>
                                    <span>{{ $catName }}</span>
                                    <span class="text-[11px] text-[#53625b] font-normal">({{ $catData['count'] }})</span>
                                </span>
                                <span class="font-mono font-bold text-[#191c1c]">
                                    {{ $currencySymbol }} {{ number_format($catAmt, 2) }} <span class="text-[#53625b] font-normal">({{ $pct }}%)</span>
                                </span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-[#f2f4f3] overflow-hidden">
                                <div class="h-full rounded-full transition-all" style="width: {{ max($pct, $catAmt > 0 ? 3 : 0) }}%; background-color: {{ $catData['color'] }};"></div>
                            </div>
                        </div>
                    @endforeach

                    @if(!$hasCategories)
                        <div class="py-8 text-center text-secondary text-xs">
                            <span class="material-symbols-outlined text-[32px] text-outline mb-1">receipt_long</span>
                            <p class="font-medium text-on-surface">No outbound expenditures recorded yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="pt-4 border-t border-[#f2f4f3] flex items-center justify-between text-xs text-[#53625b]">
                <span>Total Calculated Outflows:</span>
                <span class="font-mono font-bold text-[#191c1c]">{{ $currencySymbol }} {{ number_format($grossOutflow, 2) }}</span>
            </div>
        </div>

        <!-- Monthly Outflow Trend (100% Dynamic Bars) -->
        <div class="lg:col-span-6 bg-white rounded-2xl p-6 border border-[#e6e9e8] shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-1">
                    <h3 class="text-base font-bold font-heading text-[#191c1c] tracking-tight">Monthly Outflow Trend</h3>
                    <span class="text-xs text-[#53625b] font-mono">Peak: {{ $currencySymbol }} {{ number_format($maxMonthly, 2) }}</span>
                </div>
                <p class="text-xs text-[#53625b] mb-6">Historical expenditure comparison dynamically extracted from your transaction dates</p>
                
                <div class="flex items-end justify-between gap-3 h-48 pt-4 border-b border-[#f2f4f3] px-2">
                    @foreach($chartMonths as $mLabel => $mAmt)
                        @php
                            $barHeight = $maxMonthly > 0 ? max(round(($mAmt / $maxMonthly) * 100), ($mAmt > 0 ? 15 : 6)) : 6;
                            $isTop = ($mAmt == $maxMonthly && $mAmt > 0);
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-2 group relative">
                            <!-- Tooltip on hover -->
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity absolute -top-8 bg-[#191c1c] text-white text-[10px] font-mono px-2 py-0.5 rounded shadow pointer-events-none whitespace-nowrap z-10">
                                {{ $currencySymbol }} {{ number_format($mAmt, 2) }}
                            </div>
                            
                            <div class="w-full rounded-xl transition-all {{ $isTop ? 'bg-gradient-to-t from-[#004226] to-[#0f5b38] shadow-sm' : ($mAmt > 0 ? 'bg-[#2b7a4b] hover:bg-[#004226]' : 'bg-[#f2f4f3]') }}" 
                                 style="height: {{ $barHeight }}%"></div>
                            <span class="text-[10px] font-mono font-bold uppercase {{ $isTop ? 'text-[#004226]' : 'text-[#53625b]' }}">
                                {{ substr($mLabel, 0, 3) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-5 flex items-center justify-between text-xs text-[#53625b]">
                <span>Mean Monthly Outflow: <strong class="text-[#191c1c] font-mono font-bold">{{ $currencySymbol }} {{ number_format($avgMonthly, 2) }}</strong></span>
                <a href="{{ url('account-statement') }}" class="font-bold text-[#004226] hover:underline flex items-center gap-1">
                    <span>Export Statement</span>
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Outbound Settlements Table (Dynamic Live Ledger) -->
    <div class="bg-white rounded-2xl border border-[#e6e9e8] shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-4 flex items-center justify-between bg-[#f8faf9] border-b border-[#e6e9e8]">
            <div class="flex items-center gap-2.5">
                <span class="font-heading font-bold text-sm text-[#191c1c]">Recent Outbound Disbursements</span>
                <span class="px-2 py-0.5 rounded-full bg-[#eceeed] text-[#53625b] text-[11px] font-semibold">
                    {{ count($recentOutbound) }} Records
                </span>
            </div>
            <a href="{{ url('transactionslist') }}" class="text-xs font-bold text-[#004226] hover:underline flex items-center gap-1">
                <span>View Full Ledger</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#f8faf9] text-[#53625b] uppercase font-semibold text-[11px] tracking-wider border-b border-[#e6e9e8]">
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Reference ID</th>
                        <th class="py-3 px-4">Narration / Counterparty</th>
                        <th class="py-3 px-4 text-right">Amount Debited</th>
                        <th class="py-3 px-4 text-right">Resulting Balance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f2f4f3]">
                    @forelse(array_slice($recentOutbound, 0, 8) as $row)
                        @php
                            $isCharge = (strtolower($row->type ?? '') == 'charges');
                        @endphp
                        <tr class="hover:bg-[#f8faf9] transition-colors">
                            <td class="py-3 px-4 text-[#53625b] whitespace-nowrap font-medium">
                                {{ date("d M Y, H:i", strtotime($row->datetime)) }}
                            </td>
                            <td class="py-3 px-4">
                                @if($isCharge)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#eceeed] text-[#53625b]">
                                        Fee / Charge
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#ffdad6] text-[#ba1a1a]">
                                        Outbound Wire
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-mono text-[#53625b]">{{ $row->tran_id }}</td>
                            <td class="py-3 px-4 font-medium text-[#191c1c]">
                                {{ !empty($row->reason) ? $row->reason : ($isCharge ? 'Operational Transfer Fee' : 'Wire Dispatch') }}
                            </td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-[#ba1a1a]">
                                -{{ $currencySymbol }} {{ number_format($row->amount, 2) }}
                            </td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-[#191c1c]">
                                {{ $currencySymbol }} {{ number_format($row->balance, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-[#53625b]">
                                No outbound transactions found on this account.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('footer')
