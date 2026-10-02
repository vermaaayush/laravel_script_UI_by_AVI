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
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-slate-900 tracking-tight">Same Bank Transfer</h2>
            <p class="text-sm text-slate-500 mt-0.5">Send funds instantly to another <?= $confiG->bank_name ?? 'Equitable Bank' ?> account holder.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ asset('add-beneficiaries') }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors shadow-2xs flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[17px]">person_add</span>
                <span>Add Beneficiary</span>
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('flash::message')

    <!-- Security Tip -->
    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200/80 flex items-start gap-3">
        <span class="material-symbols-outlined text-amber-600 shrink-0 text-[20px]">verified_user</span>
        <p class="text-xs text-amber-900 leading-relaxed">
            Please confirm the beneficiary account number. Transfers within <?= $confiG->bank_name ?? 'Equitable Bank' ?> clear immediately with instant liquidity credit.
        </p>
    </div>

    <!-- Transfer Form Card -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#edf0f4] shadow-card">
        <form id="form-wizard1" method="POST" action="{{ asset('initiate-same-bank-transfer') }}" class="space-y-5">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />

            <!-- From Account -->
            <div>
                <label for="transfer_from" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Select Debit Account</label>
                <select name="transfer_from" id="transfer_from" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-900 font-semibold focus:bg-white focus:border-slate-800 outline-none font-mono cursor-pointer">
                    <option value="">-- Select Source Account --</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->account_no }}">
                            {{ $account->account_no }} ({{ $account->account_currency }} {{ number_format($account->available_balance, 2) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Beneficiary Selector -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="beneficiary_account" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Select Registered Beneficiary</label>
                    <a href="{{ asset('add-beneficiaries') }}" class="text-xs font-bold text-[#c59b27] hover:underline flex items-center gap-1">
                        <span>+ Add New</span>
                    </a>
                </div>
                <select name="beneficiary_account" id="beneficiary_account" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-900 font-semibold focus:bg-white focus:border-slate-800 outline-none font-mono cursor-pointer">
                    <option value="">-- Select Beneficiary --</option>
                    @foreach($Ba_beneficiary as $Ba_bene)
                        <option value="{{ $Ba_bene->beneficiary_account }}">
                            <?php 
                                if($Ba_bene->account){
                                    echo $Ba_bene->account->account_title . ' — ' . $Ba_bene->beneficiary_account;
                                } else {
                                    echo $Ba_bene->beneficiary_account;
                                }
                            ?>
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Amount Input -->
            <div>
                <label for="amount" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Amount to Transfer</label>
                <div class="relative rounded-2xl bg-slate-50 border border-slate-200 focus-within:border-slate-800 focus-within:bg-white focus-within:ring-2 focus-within:ring-slate-900/5 transition-all overflow-hidden p-3 sm:p-4">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-slate-400">$</span>
                        <input type="text" name="amount" id="amount" required placeholder="0.00" class="w-full bg-transparent border-0 text-3xl sm:text-4xl font-extrabold text-slate-900 font-sans focus:ring-0 p-0 outline-none">
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Payment Reference / Description</label>
                <input type="text" name="description" id="description" placeholder="e.g. Invoice settlement, Consulting fee" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs text-slate-800 focus:bg-white focus:border-slate-800 outline-none transition-all">
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Zero Fee Intra-Bank Wire</span>
                <button type="submit" id="submit-first-step-sb" class="px-8 py-3 rounded-xl gold-gradient-btn text-xs font-bold transition-all shadow-md flex items-center gap-2">
                    <span>Continue</span>
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
