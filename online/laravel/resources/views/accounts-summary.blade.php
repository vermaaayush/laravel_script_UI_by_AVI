<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-7xl mx-auto w-full space-y-6 pb-16 font-sans">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold uppercase tracking-wider mb-2">
                <span class="material-symbols-outlined text-[15px]">account_balance</span>
                <span>Institutional Custody</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Custody Accounts Summary</h1>
            <p class="text-sm text-secondary mt-1">Overview of your registered treasury accounts, real-time balances, and available clearing lines.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ asset('additional-accounts') }}" class="px-4 py-2 rounded-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface text-xs font-semibold hover:bg-surface-container transition-colors shadow-sm flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">add_circle</span>
                <span>Open New Vault</span>
            </a>
            <a href="{{ asset('account-statement') }}" class="px-5 py-2 rounded-full bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-md flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">description</span>
                <span>Statements</span>
            </a>
        </div>
    </div>

    <?php if(isset($_user) && $_user->status_message != NULL && !empty($_user->status_message)){ ?>
        <div class="p-4 bg-surface-container-lowest text-on-surface rounded-2xl border border-primary/20 flex items-start gap-3 shadow-sm">
            <span class="material-symbols-outlined text-primary shrink-0 mt-0.5">info</span>
            <div class="text-xs leading-relaxed">
                <strong class="font-bold block mb-0.5 text-on-surface">Institutional Advisory</strong>
                <span class="text-secondary"><?= $_user->status_message ?></span>
            </div>
        </div>
    <?php } ?>

    <!-- Accounts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach($accounts as $row)
        <div class="bg-surface-container-lowest rounded-3xl p-6 border border-outline-variant/30 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group relative overflow-hidden">
            <!-- Header: Account No & Status -->
            <div class="flex justify-between items-start mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-surface-container-low border border-outline-variant/20 text-primary flex items-center justify-center font-bold shrink-0">
                        <span class="material-symbols-outlined text-[24px]">account_balance_wallet</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold text-secondary uppercase tracking-wider">Account Number</span>
                        <h3 class="text-lg font-heading font-bold text-on-surface tracking-tight font-mono">{{ $row->account_no }}</h3>
                        <p class="text-xs text-secondary flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[14px]">store</span>
                            {{ $row->branch_name ?? 'Main Commercial Branch' }}
                        </p>
                    </div>
                </div>

                <div>
                    @if($row->access == 1)
                        <span class="px-3 py-1 bg-primary-fixed text-primary text-xs font-bold rounded-full inline-flex items-center gap-1.5 shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Active
                        </span>
                    @elseif($row->access == 3)
                        <span class="px-3 py-1 bg-error-container text-error text-xs font-bold rounded-full inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Suspended
                        </span>
                    @elseif($row->access == 2)
                        <span class="px-3 py-1 bg-error-container text-error text-xs font-bold rounded-full inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span> Blocked
                        </span>
                    @elseif($row->access == 4)
                        <span class="px-3 py-1 bg-secondary-container text-on-secondary-container text-xs font-bold rounded-full inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Restricted
                        </span>
                    @endif
                </div>
            </div>

            <!-- Balances Panel -->
            <div class="bg-surface-container-low rounded-2xl p-4 border border-outline-variant/20 mb-5 space-y-3">
                <div class="flex justify-between items-baseline border-b border-outline-variant/20 pb-3">
                    <span class="text-xs font-semibold text-secondary">Available Balance</span>
                    <div class="text-right">
                        <span class="text-xs font-bold text-secondary mr-1">{{ $row->account_currency }}</span>
                        <span class="text-2xl font-heading font-bold text-on-surface tracking-tight">
                            <?php echo number_format($row->available_balance, 2); ?>
                        </span>
                    </div>
                </div>

                <div class="flex justify-between items-center text-xs">
                    <span class="text-secondary font-medium">Ledger Balance</span>
                    <span class="font-bold text-on-surface font-mono">
                        {{ $row->account_currency }} <?php echo number_format($row->ledge_balance, 2); ?>
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-2 border-t border-surface-container">
                <a href="{{ asset('account-statement') }}" class="text-xs font-semibold text-secondary hover:text-primary flex items-center gap-1 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                    <span>Statement</span>
                </a>
                <a href="{{ asset('account-quicklook/' . $row->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-sm">
                    <span>Quick Look</span>
                    <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@include('footer')
