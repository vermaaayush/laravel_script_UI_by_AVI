<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<!-- Main Content Wrapper -->
<div class="max-w-3xl mx-auto w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Own Account Transfer</h2>
            <p class="text-sm text-slate-500 mt-0.5">Move funds instantly with zero fee between your commercial accounts.</p>
        </div>
        <a href="{{ asset('accounts-summary') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors shadow-2xs flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[17px]">arrow_back</span>
            <span>Accounts</span>
        </a>
    </div>

    @include('flash::message')

    <!-- Security Indicator -->
    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200/80 flex items-center gap-3">
        <span class="material-symbols-outlined text-emerald-600 shrink-0 text-[20px]">shield_with_heart</span>
        <p class="text-xs text-emerald-900 leading-snug">
            Internal transfers settle in real-time 24/7 with zero transaction fees and cryptographic verification.
        </p>
    </div>

    <!-- Transfer Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#edf0f4] shadow-card">
        <form id="form-wizard1" method="POST" action="{{ asset('initiate-own-account-transfer') }}" class="space-y-6">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />

            <!-- From & To Accounts Selector Bento Box -->
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-11 gap-3 items-center">
                    <!-- From Account -->
                    <div class="md:col-span-5 space-y-1.5">
                        <label for="transfer_from" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Debit Source Account</label>
                        <div class="relative">
                            <select name="transfer_from" id="transfer_from" required onchange="getAccounts();" class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-3 text-xs text-slate-900 font-semibold focus:border-slate-800 focus:ring-2 focus:ring-slate-900/5 outline-none font-mono cursor-pointer">
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
                        <div class="w-9 h-9 rounded-full bg-white border border-slate-200 shadow-2xs flex items-center justify-center text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">swap_horiz</span>
                        </div>
                    </div>

                    <!-- To Account -->
                    <div class="md:col-span-5 space-y-1.5">
                        <label for="transfer_to" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Credit Target Account</label>
                        <div class="relative">
                            <select name="transfer_to" id="transfer_to" required class="w-full bg-white border border-slate-200 rounded-xl px-3.5 py-3 text-xs text-slate-900 font-semibold focus:border-slate-800 focus:ring-2 focus:ring-slate-900/5 outline-none font-mono cursor-pointer">
                                <option value="">-- Select Destination Account --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amount Input -->
            <div>
                <label for="amount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Transfer Amount</label>
                <div class="relative rounded-2xl bg-slate-50 border border-slate-200 focus-within:border-slate-800 focus-within:bg-white focus-within:ring-2 focus-within:ring-slate-900/5 transition-all overflow-hidden p-3 sm:p-4">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-slate-400">$</span>
                        <input type="text" name="amount" id="amount" required placeholder="0.00" class="w-full bg-transparent border-0 text-3xl sm:text-4xl font-extrabold text-slate-900 font-sans focus:ring-0 p-0 outline-none">
                    </div>
                </div>
            </div>

            <!-- Narration / Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Description / Memo (Optional)</label>
                <input type="text" name="description" id="description" placeholder="e.g. Allocation to High-Yield Savings" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none transition-all">
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Instant Liquidity Settlement</span>
                <button type="submit" id="submit-first-step" class="px-8 py-3 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-md flex items-center gap-2">
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
