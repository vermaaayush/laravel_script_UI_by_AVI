<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-7xl mx-auto w-full space-y-6 pb-16 font-sans">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-secondary mb-1">
                <a class="hover:text-primary transition-colors" href="{{ asset('accounts-summary') }}">Accounts</a>
                <span>/</span>
                <span class="text-on-surface font-semibold">{{ $account[0]->account_title }}</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight flex items-center gap-2.5">
                <span>{{ $account[0]->account_title }}</span>
                <span class="text-xs font-mono font-medium px-2.5 py-1 bg-surface-container rounded-lg text-secondary">
                    •••• {{ substr($account[0]->account_no, -4) }}
                </span>
            </h1>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ asset('account-statement') }}" class="px-4 py-2 rounded-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface text-xs font-semibold hover:bg-surface-container transition-colors shadow-sm flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">description</span>
                <span>Statement</span>
            </a>
            <a href="{{ asset('own-account-transfer') }}" class="px-5 py-2 rounded-full bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-md flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">sync_alt</span>
                <span>Transfer Funds</span>
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- Left: Balance Card & Transactions (8 cols) -->
        <div class="lg:col-span-8 space-y-5">
            <!-- Sovereign Emerald Financial Hero Card -->
            <div class="rounded-3xl p-6 sm:p-7 text-on-primary relative overflow-hidden flex flex-col justify-between min-h-[220px] bg-gradient-to-br from-[#002111] via-primary to-primary-container shadow-xl border border-white/10">
                <div class="absolute -right-16 -top-16 w-56 h-56 bg-primary-fixed/15 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <span class="text-xs font-semibold text-primary-fixed-dim/90 uppercase tracking-wider">Available Account Balance</span>
                        <div class="flex items-baseline gap-2 mt-2">
                            <span class="text-2xl text-primary-fixed font-bold">{{ $account[0]->account_currency }}</span>
                            <span class="text-4xl sm:text-5xl font-heading font-extrabold text-white tracking-tight">
                                <?php echo number_format($account[0]->available_balance, 2); ?>
                            </span>
                        </div>
                        <div class="inline-flex items-center gap-1.5 text-primary-fixed text-xs font-semibold mt-3 bg-white/10 px-3 py-1 rounded-full border border-white/15 backdrop-blur-sm">
                            <span class="material-symbols-outlined text-[14px]">check_circle</span>
                            <span>Verified & Liquid</span>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="text-[11px] font-bold text-primary-fixed-dim uppercase tracking-wider block">Ledger Balance</span>
                        <span class="text-base font-bold text-white font-mono">
                            {{ $account[0]->account_currency }} <?php echo number_format($account[0]->ledge_balance ?? $account[0]->available_balance, 2); ?>
                        </span>
                        <div class="mt-2 text-xs text-white/70">Holds: <strong class="text-white">{{ $account[0]->account_currency }} 0.00</strong></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-white/15 flex items-center justify-between text-xs text-white/80 relative z-10 mt-6">
                    <span>Account Number: <strong class="text-white font-mono">{{ $account[0]->account_no }}</strong></span>
                    <span>Status: <strong class="text-primary-fixed">Active</strong></span>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/30 shadow-sm">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
                    <div>
                        <h3 class="text-base font-heading font-bold text-on-surface tracking-tight">Recent Account Settlements</h3>
                        <p class="text-xs text-secondary">Ledger activity on account {{ $account[0]->account_no }}</p>
                    </div>
                    <a href="{{ asset('account-statement') }}" class="text-xs font-bold text-primary hover:underline">Full Statement</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low/40 border-b border-surface-container text-xs font-semibold text-secondary uppercase tracking-wider">
                                <th class="py-3 px-4">Date & Time</th>
                                <th class="py-3 px-4">Description</th>
                                <th class="py-3 px-4">Transaction ID</th>
                                <th class="py-3 px-4 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container text-xs">
                            @forelse($transactions ?? [] as $row)
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="py-3.5 px-4 text-secondary whitespace-nowrap">
                                    <?= date("d M Y, h:i A", strtotime($row->datetime)); ?>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 {{ $row->type == 'debited' || $row->type == 'charges' ? 'bg-error-container text-error' : 'bg-primary-fixed/50 text-primary' }}">
                                            <span class="material-symbols-outlined text-[17px]">{{ $row->type == 'debited' || $row->type == 'charges' ? 'north_east' : 'south_west' }}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-on-surface line-clamp-1">{{ $row->reason ?? 'Transaction Record' }}</p>
                                            <span class="text-[10px] text-secondary capitalize">{{ $row->type }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-secondary">{{ $row->tran_id }}</td>
                                <td class="py-3.5 px-4 text-right font-mono font-bold {{ $row->type == 'debited' || $row->type == 'charges' ? 'text-on-surface' : 'text-primary' }}">
                                    @if($row->type == 'debited' || $row->type == 'charges')
                                        - {{ $account[0]->account_currency }} <?php echo number_format($row->amount, 2); ?>
                                    @else
                                        + {{ $account[0]->account_currency }} <?php echo number_format($row->amount, 2); ?>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-secondary">
                                    <span class="material-symbols-outlined text-4xl block mb-2 text-outline">receipt_long</span>
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
            <div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/30 shadow-sm">
                <h3 class="text-sm font-heading font-bold text-on-surface tracking-tight mb-4">Quick Operations</h3>
                <div class="grid grid-cols-2 gap-2.5">
                    <a href="{{ url('transfer-to-same-bank') }}" class="p-3.5 rounded-2xl bg-surface-container-low hover:bg-surface-container transition-colors text-center flex flex-col items-center gap-1.5 border border-outline-variant/20">
                        <span class="material-symbols-outlined text-primary text-[22px]">send</span>
                        <span class="text-xs font-semibold text-on-surface">Same Bank</span>
                    </a>
                    <a href="{{ url('transfer-to-other-bank') }}" class="p-3.5 rounded-2xl bg-surface-container-low hover:bg-surface-container transition-colors text-center flex flex-col items-center gap-1.5 border border-outline-variant/20">
                        <span class="material-symbols-outlined text-primary text-[22px]">swap_horiz</span>
                        <span class="text-xs font-semibold text-on-surface">Wire Transfer</span>
                    </a>
                    <a href="{{ url('own-account-transfer') }}" class="p-3.5 rounded-2xl bg-surface-container-low hover:bg-surface-container transition-colors text-center flex flex-col items-center gap-1.5 border border-outline-variant/20">
                        <span class="material-symbols-outlined text-primary text-[22px]">sync_alt</span>
                        <span class="text-xs font-semibold text-on-surface">Reallocate</span>
                    </a>
                    <a href="{{ url('account-statement') }}" class="p-3.5 rounded-2xl bg-surface-container-low hover:bg-surface-container transition-colors text-center flex flex-col items-center gap-1.5 border border-outline-variant/20">
                        <span class="material-symbols-outlined text-primary text-[22px]">description</span>
                        <span class="text-xs font-semibold text-on-surface">Statements</span>
                    </a>
                </div>
            </div>

            <!-- Account Metadata -->
            <div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/30 shadow-sm space-y-4">
                <h3 class="text-sm font-heading font-bold text-on-surface tracking-tight">Account Parameters</h3>
                
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between items-center py-2 border-b border-surface-container">
                        <span class="text-secondary">Account Type</span>
                        <span class="font-bold text-on-surface">{{ $account[0]->account_type }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-surface-container">
                        <span class="text-secondary">Base Currency</span>
                        <span class="font-bold text-on-surface font-mono">{{ $account[0]->account_currency }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-surface-container">
                        <span class="text-secondary">Branch Servicing Desk</span>
                        <span class="font-bold text-on-surface">{{ $account[0]->branch_name ?? 'Commercial Desk' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-secondary">Clearing Status</span>
                        <span class="font-bold text-primary">Unrestricted Liquid</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')
