<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper -->
<div class="max-w-6xl mx-auto w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Spending & Cashflow Analysis</h2>
            <p class="text-sm text-slate-500 mt-0.5">Comprehensive intelligence, expense categorization, and budget trends.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-slate-500">Period:</span>
            <select class="bg-white border border-slate-200 rounded-xl px-3 py-1.5 text-xs text-slate-800 font-bold focus:outline-none shadow-2xs">
                <option>Current Fiscal Quarter</option>
                <option>Last 30 Days</option>
                <option>Last 90 Days</option>
                <option>Year to Date</option>
            </select>
        </div>
    </div>

    <!-- Analytics Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Card 1: Total Outflow -->
        <div class="bg-white rounded-3xl p-6 border border-[#edf0f4] shadow-card">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Expenditure</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight font-sans">$3,214.50</span>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">-12% MoM</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Average daily burn: $107.15</p>
            <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden mt-4">
                <div class="h-full bg-slate-900 rounded-full" style="width: 48%"></div>
            </div>
        </div>

        <!-- Card 2: Highest Expense Category -->
        <div class="bg-white rounded-3xl p-6 border border-[#edf0f4] shadow-card">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Primary Category</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-2xl font-bold text-slate-900 tracking-tight">Shopping & Retail</span>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">32%</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Total: $1,028.64 across 14 transactions</p>
            <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden mt-4">
                <div class="h-full bg-blue-500 rounded-full" style="width: 32%"></div>
            </div>
        </div>

        <!-- Card 3: Savings Retention -->
        <div class="bg-white rounded-3xl p-6 border border-[#edf0f4] shadow-card">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Income Retained</span>
            <div class="flex items-baseline gap-2 mt-2">
                <span class="text-3xl font-extrabold text-slate-900 tracking-tight font-sans">41.8%</span>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Target 35%</span>
            </div>
            <p class="text-[11px] text-slate-400 mt-1">Surpassed monthly liquidity reserve target</p>
            <div class="w-full h-1.5 rounded-full bg-slate-100 overflow-hidden mt-4">
                <div class="h-full bg-amber-500 rounded-full" style="width: 41.8%"></div>
            </div>
        </div>
    </div>

    <!-- Middle Grid: Category Breakdown + Monthly Outflow Bar Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        <!-- Category Breakdown -->
        <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-7 border border-[#edf0f4] shadow-card space-y-4">
            <h3 class="text-base font-bold text-slate-900 tracking-tight">Category Distribution</h3>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between items-center text-xs mb-1.5">
                        <span class="font-semibold text-slate-700 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Shopping & Retail
                        </span>
                        <span class="font-bold text-slate-900">$1,028.64 (32%)</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full" style="width: 32%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center text-xs mb-1.5">
                        <span class="font-semibold text-slate-700 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Food & Dining
                        </span>
                        <span class="font-bold text-slate-900">$771.48 (24%)</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: 24%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center text-xs mb-1.5">
                        <span class="font-semibold text-slate-700 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span> Travel & Transit
                        </span>
                        <span class="font-bold text-slate-900">$578.61 (18%)</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" style="width: 18%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center text-xs mb-1.5">
                        <span class="font-semibold text-slate-700 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span> Utilities & Recurring
                        </span>
                        <span class="font-bold text-slate-900">$450.03 (14%)</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-purple-500 rounded-full" style="width: 14%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center text-xs mb-1.5">
                        <span class="font-semibold text-slate-700 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span> Other Disbursements
                        </span>
                        <span class="font-bold text-slate-900">$385.74 (12%)</span>
                    </div>
                    <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-slate-400 rounded-full" style="width: 12%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Outflow Trend -->
        <div class="lg:col-span-6 bg-white rounded-3xl p-6 sm:p-7 border border-[#edf0f4] shadow-card flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900 tracking-tight mb-1">Monthly Outflow Trend</h3>
                <p class="text-xs text-slate-400 mb-6">Historical expenditure comparison</p>
                <div class="flex items-end justify-between gap-3 h-44 pt-4 border-b border-slate-100 px-2">
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-slate-100 hover:bg-slate-200 rounded-xl transition-all" style="height: 60%"></div>
                        <span class="text-[10.5px] font-bold text-slate-400">May</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-slate-100 hover:bg-slate-200 rounded-xl transition-all" style="height: 75%"></div>
                        <span class="text-[10.5px] font-bold text-slate-400">Jun</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-slate-100 hover:bg-slate-200 rounded-xl transition-all" style="height: 90%"></div>
                        <span class="text-[10.5px] font-bold text-slate-400">Jul</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-slate-100 hover:bg-slate-200 rounded-xl transition-all" style="height: 82%"></div>
                        <span class="text-[10.5px] font-bold text-slate-400">Aug</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-gradient-to-t from-amber-500 to-[#c59b27] rounded-xl shadow-xs" style="height: 68%"></div>
                        <span class="text-[10.5px] font-bold text-slate-900">Sep</span>
                    </div>
                </div>
            </div>
            <div class="pt-4 flex items-center justify-between text-xs text-slate-500">
                <span>Average monthly expenditure: <strong class="text-slate-800">$3,420</strong></span>
                <a href="{{ asset('account-statement') }}" class="font-bold text-[#c59b27] hover:underline">Download Report</a>
            </div>
        </div>
    </div>
</div>

@include('footer')
