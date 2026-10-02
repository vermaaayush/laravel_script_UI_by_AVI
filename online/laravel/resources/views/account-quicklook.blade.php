<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper -->
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a class="hover:text-slate-900 transition-colors" href="{{ asset('accounts-summary') }}">Accounts</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">{{ $account[0]->account_title }}</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight flex items-center gap-2.5">
                <span>{{ $account[0]->account_title }}</span>
                <span class="text-xs font-mono font-medium px-2.5 py-1 bg-slate-100 rounded-lg text-slate-600">
                    •••• {{ substr($account[0]->account_no, -4) }}
                </span>
            </h1>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ asset('account-statement') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors shadow-2xs flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">description</span>
                <span>Statement</span>
            </a>
            <a href="{{ asset('own-account-transfer') }}" class="px-4 py-2 rounded-xl gold-gradient-btn text-xs font-bold transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">sync_alt</span>
                <span>Transfer Funds</span>
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- Left: Balance Card & Transactions (8 cols) -->
        <div class="lg:col-span-8 space-y-5">
            <!-- Dark Financial Card for This Account -->
            <div class="dark-hero-card rounded-3xl p-6 sm:p-7 text-white relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                <div class="absolute -right-16 -top-16 w-56 h-56 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <span class="text-xs font-semibold text-slate-400">Available Account Balance</span>
                        <div class="flex items-baseline gap-2 mt-2">
                            <span class="text-2xl text-amber-400 font-bold">{{ $account[0]->account_currency }}</span>
                            <span class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight font-sans">
                                <?php echo number_format($account[0]->available_balance, 2); ?>
                            </span>
                        </div>
                        <div class="inline-flex items-center gap-1.5 text-emerald-400 text-xs font-semibold mt-2 bg-emerald-500/10 px-2.5 py-0.5 rounded-full border border-emerald-500/20">
                            <span class="material-symbols-outlined text-[14px]">check_circle</span>
                            <span>Verified & Liquid</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Ledger Balance</span>
                        <span class="text-base font-bold text-slate-200 font-mono">
                            {{ $account[0]->account_currency }} <?php echo number_format($account[0]->ledge_balance ?? $account[0]->available_balance, 2); ?>
                        </span>
                        <div class="mt-2 text-xs text-slate-400">Holds: <strong class="text-white">{{ $account[0]->account_currency }} 0.00</strong></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-white/10 flex items-center justify-between text-xs text-slate-400 relative z-10 mt-4">
                    <span>Account Number: <strong class="text-white font-mono">{{ $account[0]->account_no }}</strong></span>
                    <span>Status: <strong class="text-emerald-400">Active</strong></span>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="bg-white rounded-3xl p-6 border border-[#edf0f4] shadow-card">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 tracking-tight">Recent Transactions</h3>
                        <p class="text-xs text-slate-500">Activity on account {{ $account[0]->account_no }}</p>
                    </div>
                    <a href="{{ asset('account-statement') }}" class="text-xs font-semibold text-[#c59b27] hover:underline">Full Statement</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                <th class="py-3 px-4">Date & Time</th>
                                <th class="py-3 px-4">Description</th>
                                <th class="py-3 px-4">Transaction ID</th>
                                <th class="py-3 px-4 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($transactions as $row)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap">
                                    <?= date("d M Y, h:i A", strtotime($row->datetime)); ?>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ $row->type == 'debited' || $row->type == 'charges' ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600' }}">
                                            <span class="material-symbols-outlined text-[17px]">{{ $row->type == 'debited' || $row->type == 'charges' ? 'north_east' : 'south_west' }}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 line-clamp-1">{{ $row->reason ?? 'Transaction Record' }}</p>
                                            <span class="text-[10px] text-slate-400 capitalize">{{ $row->type }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-slate-500">{{ $row->tran_id }}</td>
                                <td class="py-3.5 px-4 text-right font-mono font-bold {{ $row->type == 'debited' || $row->type == 'charges' ? 'text-slate-900' : 'text-emerald-600' }}">
                                    @if($row->type == 'debited' || $row->type == 'charges')
                                        - {{ $account[0]->account_currency }} <?php echo number_format($row->amount, 2); ?>
                                    @else
                                        + {{ $account[0]->account_currency }} <?php echo number_format($row->amount, 2); ?>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400">
                                    <span class="material-symbols-outlined text-4xl block mb-2 text-slate-300">receipt_long</span>
                                    <span>No transactions recorded yet for this account.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Actions & Details Sidebar (4 cols) -->
        <div class="lg:col-span-4 space-y-5">
            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl p-6 border border-[#edf0f4] shadow-card">
                <h3 class="text-sm font-bold text-slate-900 tracking-tight mb-4">Account Actions</h3>
                <div class="grid grid-cols-2 gap-2.5">
                    <a href="{{ asset('own-account-transfer') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all text-center group">
                        <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] mb-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">swap_horiz</span>
                        </div>
                        <span class="text-xs font-semibold text-slate-700 group-hover:text-[#9c7614]">Transfer</span>
                    </a>
                    <a href="{{ asset('account-statement') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all text-center group">
                        <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] mb-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">description</span>
                        </div>
                        <span class="text-xs font-semibold text-slate-700 group-hover:text-[#9c7614]">Statement</span>
                    </a>
                    <a href="{{ asset('request-card') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all text-center group">
                        <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] mb-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">credit_card</span>
                        </div>
                        <span class="text-xs font-semibold text-slate-700 group-hover:text-[#9c7614]">Debit Card</span>
                    </a>
                    <a href="{{ asset('request-cheque-book') }}" class="flex flex-col items-center justify-center p-3 rounded-2xl bg-slate-50 hover:bg-[#faf6ed] hover:border-[#e9c668]/50 border border-slate-100 transition-all text-center group">
                        <div class="w-10 h-10 rounded-xl bg-white shadow-2xs flex items-center justify-center text-slate-700 group-hover:text-[#c59b27] mb-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[20px]">fact_check</span>
                        </div>
                        <span class="text-xs font-semibold text-slate-700 group-hover:text-[#9c7614]">Cheque Book</span>
                    </a>
                </div>
            </div>

            <!-- Details Card -->
            <div class="bg-white rounded-3xl p-6 border border-[#edf0f4] shadow-card">
                <h3 class="text-sm font-bold text-slate-900 tracking-tight mb-4">Account Information</h3>
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Account Title</span>
                        <span class="font-bold text-slate-800">{{ $account[0]->account_title }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Account Number</span>
                        <span class="font-bold text-slate-800 font-mono">{{ $account[0]->account_no }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Currency</span>
                        <span class="font-bold text-slate-800">{{ $account[0]->account_currency }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Branch</span>
                        <span class="font-bold text-slate-800">{{ $account[0]->branch_name ?? 'Main Branch' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5">
                        <span class="text-slate-500">Status</span>
                        @if($account[0]->access == 1)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[11px]">Active</span>
                        @elseif($account[0]->access == 3)
                            <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 font-bold text-[11px]">Suspended</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-bold text-[11px]">Restricted</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
