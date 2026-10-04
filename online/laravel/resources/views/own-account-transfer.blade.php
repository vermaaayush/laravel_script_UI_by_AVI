<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-3xl mx-auto w-full space-y-6 pb-12 font-sans">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold uppercase tracking-wider mb-2">
                <span class="material-symbols-outlined text-[15px]">sync_alt</span>
                <span>Internal Liquidity Reallocation</span>
            </div>
            <h1 class="font-heading font-bold text-2xl sm:text-3xl text-on-surface tracking-tight">Own Account Transfer</h1>
            <p class="text-sm text-secondary mt-1">Move funds instantly with zero fee between your personal or commercial vaults.</p>
        </div>
        <a href="{{ asset('accounts-summary') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface text-xs font-semibold hover:bg-surface-container transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[17px]">arrow_back</span>
            <span>Accounts</span>
        </a>
    </div>

    @include('flash::message')

    <!-- Security Indicator -->
    <div class="p-4 bg-surface-container-lowest rounded-2xl border border-primary/20 flex items-center gap-3 shadow-sm">
        <span class="material-symbols-outlined text-primary shrink-0 text-[20px]">shield</span>
        <p class="text-xs text-secondary leading-snug">
            Internal transfers settle in real-time 24/7 with zero transaction fees and cryptographic ledger verification.
        </p>
    </div>

    <!-- Transfer Form Card -->
    <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-outline-variant/30 shadow-sm">
        <form id="form-wizard1" method="POST" action="{{ asset('initiate-own-account-transfer') }}" class="space-y-6">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />

            <!-- From & To Accounts Selector Bento Box -->
            <div class="p-5 rounded-2xl bg-surface-container-low border border-outline-variant/30 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-11 gap-3 items-center">
                    <!-- From Account -->
                    <div class="md:col-span-5 space-y-1.5">
                        <label for="transfer_from" class="block text-xs font-bold text-secondary uppercase tracking-wider">Debit Source Account</label>
                        <div class="relative">
                            <select name="transfer_from" id="transfer_from" required onchange="getAccounts();" class="w-full bg-surface-container-lowest border border-outline-variant/30 rounded-xl px-3.5 py-3 text-xs text-on-surface font-semibold focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none font-mono cursor-pointer transition-all">
                                <option value="">-- Select Source Account --</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->account_no }}">
                                        {{ $account->account_no }} ({{ $account->account_currency }} {{ number_format($account->available_balance, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Swap Icon -->
                    <div class="md:col-span-1 flex items-center justify-center pt-2 md:pt-5">
                        <div class="w-9 h-9 rounded-full bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">swap_horiz</span>
                        </div>
                    </div>

                    <!-- To Account -->
                    <div class="md:col-span-5 space-y-1.5">
                        <label for="transfer_to" class="block text-xs font-bold text-secondary uppercase tracking-wider">Credit Target Account</label>
                        <div class="relative">
                            <select name="transfer_to" id="transfer_to" required class="w-full bg-surface-container-lowest border border-outline-variant/30 rounded-xl px-3.5 py-3 text-xs text-on-surface font-semibold focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none font-mono cursor-pointer transition-all">
                                <option value="">-- Select Destination Account --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amount Input -->
            <div>
                <label for="amount" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Transfer Amount</label>
                <div class="relative rounded-2xl bg-surface-container-low border border-outline-variant/30 focus-within:border-primary focus-within:bg-surface-container-lowest focus-within:ring-2 focus-within:ring-primary/20 transition-all overflow-hidden p-3 sm:p-4">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-secondary">$</span>
                        <input type="text" name="amount" id="amount" required placeholder="0.00" class="w-full bg-transparent border-0 text-3xl sm:text-4xl font-extrabold text-on-surface font-sans focus:ring-0 p-0 outline-none">
                    </div>
                </div>
            </div>

            <!-- Narration / Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Description / Memo (Optional)</label>
                <input type="text" name="description" id="description" placeholder="e.g. Allocation to High-Yield Savings" class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary outline-none transition-all">
            </div>

            <!-- Submit -->
            <div class="pt-5 border-t border-surface-container flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-xs text-secondary font-medium">Instant Liquidity Settlement</span>
                <button type="submit" id="submit-first-step" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2">
                    <span>Continue Transfer</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id){
        $('.bankPopup'+id).modal('show');
    }
</script>

@include('footer')
