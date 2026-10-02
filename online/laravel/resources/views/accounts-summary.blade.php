<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper -->
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Account Summary</h2>
            <p class="text-sm text-slate-500 mt-0.5">Overview of your registered bank accounts, available limits, and balances.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ asset('additional-accounts') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors shadow-2xs flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">add_circle</span>
                <span>Open New Account</span>
            </a>
            <a href="{{ asset('account-statement') }}" class="px-4 py-2 rounded-xl gold-gradient-btn text-xs font-bold transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">description</span>
                <span>Statements</span>
            </a>
        </div>
    </div>

    <?php if(isset($_user) && $_user->status_message != NULL && !empty($_user->status_message)){ ?>
        <div class="p-4 bg-amber-50 text-amber-900 rounded-2xl border border-amber-200/80 flex items-start gap-3 shadow-2xs">
            <span class="material-symbols-outlined text-amber-600 shrink-0">info</span>
            <div class="text-xs leading-relaxed">
                <strong class="font-bold block mb-0.5">Account Notice</strong>
                <span><?= $_user->status_message ?></span>
            </div>
        </div>
    <?php } ?>

    <!-- Accounts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach($accounts as $row)
        <div class="bg-white rounded-3xl p-6 border border-[#edf0f4] shadow-card hover:shadow-card-hover transition-all flex flex-col justify-between group relative overflow-hidden">
            <!-- Header: Account No & Status -->
            <div class="flex justify-between items-start mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 text-amber-400 flex items-center justify-center font-bold shadow-2xs shrink-0">
                        <span class="material-symbols-outlined text-[24px]">account_balance_wallet</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Account Number</span>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight font-mono">{{ $row->account_no }}</h3>
                        <p class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[14px] text-slate-400">store</span>
                            {{ $row->branch_name ?? 'Main Commercial Branch' }}
                        </p>
                    </div>
                </div>

                <div>
                    @if($row->access == 1)
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200/60 inline-flex items-center gap-1.5 shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                        </span>
                    @elseif($row->access == 3)
                        <span class="px-3 py-1 bg-rose-50 text-rose-700 text-xs font-bold rounded-full border border-rose-200/60 inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Suspended
                        </span>
                    @elseif($row->access == 2)
                        <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-bold rounded-full border border-red-200/60 inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Blocked
                        </span>
                    @elseif($row->access == 4)
                        <span class="px-3 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-200/60 inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Restricted
                        </span>
                    @endif
                </div>
            </div>

            <!-- Balances Panel -->
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 mb-5 space-y-3">
                <div class="flex justify-between items-baseline border-b border-slate-200/70 pb-3">
                    <span class="text-xs font-semibold text-slate-500">Available Balance</span>
                    <div class="text-right">
                        <span class="text-xs font-bold text-slate-500 mr-1">{{ $row->account_currency }}</span>
                        <span class="text-2xl font-extrabold text-slate-900 tracking-tight font-sans">
                            <?php echo number_format($row->available_balance, 2); ?>
                        </span>
                    </div>
                </div>

                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-500 font-medium">Ledger Balance</span>
                    <span class="font-bold text-slate-700 font-mono">
                        {{ $row->account_currency }} <?php echo number_format($row->ledge_balance, 2); ?>
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                <a href="{{ asset('account-statement') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                    <span>Statement</span>
                </a>
                <a href="{{ asset('account-quicklook/' . $row->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-2xs">
                    <span>Quick Look</span>
                    <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@include('footer')
