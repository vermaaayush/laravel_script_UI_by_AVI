<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- // Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<!-- Main Content Wrapper -->
<div class="max-w-7xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Security & Controls</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Transaction Limits</span>
        </div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Account Velocity Limits</h1>
                <p class="text-sm text-slate-500 mt-1">Review active transaction ceilings and monthly dispatch allowances.</p>
            </div>
            <div>
                <a href="{{ url('request-limit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span> Request Limit Increase
                </a>
            </div>
        </div>
    </div>

    @include('flash::message')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Account Selection Card -->
        <div class="lg:col-span-5">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 limit-accounts">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[18px]">account_balance_wallet</span> Select Account
                    </h3>
                    <span class="text-xs text-slate-400">{{ count($accounts) }} Accounts</span>
                </div>

                <div class="space-y-2.5">
                    @foreach($accounts as $key => $account)
                    <label for="account{{$key}}" class="flex items-center justify-between p-3.5 rounded-2xl border border-slate-200/80 hover:border-primary/50 hover:bg-slate-50/50 cursor-pointer transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" class="w-4 h-4 text-primary focus:ring-primary border-slate-300" name="cust_act_number" id="account{{$key}}" value="{{ $account->account_no }}" @if($key == 0) checked @endif>
                            <div>
                                <span class="font-mono text-sm font-bold text-slate-900 block">{{ $account->account_no }}</span>
                                <span class="text-xs text-slate-500">{{ $account->account_type }} &bull; {{ $account->branch_name }}</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 text-[18px]">chevron_right</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Active Limits Table Card -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-slate-400 text-[20px]">tune</span>
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">Active Limits Ledger</h3>
                    </div>
                    <span class="text-xs text-slate-400">Monthly Rolling Cap</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="py-3.5 px-6">Limit Category</th>
                                <th class="py-3.5 px-6">Maximum Cap</th>
                                <th class="py-3.5 px-6 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody id="limits-body" class="divide-y divide-slate-100 text-sm">
                            @forelse($limits as $limit)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-slate-900 block">{{ $limit->type }} Limit</span>
                                    <span class="text-xs text-slate-400">Monthly Rolling Window</span>
                                </td>
                                <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                    {{ $limit->account_currency . " " . number_format($limit->limit_amount, 2) }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    @if($limit->status == 0)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Review
                                        </span>
                                    @elseif($limit->status == 1)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                        </span>
                                    @elseif($limit->status == 2)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Rejected
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-slate-400">
                                    <span class="material-symbols-outlined text-[36px] text-slate-300 block mb-1">lock_open</span>
                                    <p class="text-sm font-semibold text-slate-600">Standard Baseline Limits Active</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Your account is operating on default tier transfer velocities.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-5 bg-slate-50/60 border-t border-slate-100">
                    <p class="text-xs text-slate-500 italic">
                        * Monthly outbound dispatch and withdrawal ceilings automatically refresh on the first business day following your monthly statement cycle.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
