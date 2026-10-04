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
                <span class="material-symbols-outlined text-[15px]">send_money</span>
                <span>Intra-Bank Settlement</span>
            </div>
            <h1 class="font-heading font-bold text-2xl sm:text-3xl text-on-surface tracking-tight">Same Bank Transfer</h1>
            <p class="text-sm text-secondary mt-1">Send funds instantly to another <?= $confiG->bank_name ?? 'OripioFin' ?> account holder with zero clearing delay.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ asset('add-beneficiaries') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-surface-container-lowest border border-outline-variant/30 text-on-surface text-xs font-semibold hover:bg-surface-container transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[17px]">person_add</span>
                <span>Add Beneficiary</span>
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-error-container text-error rounded-2xl text-xs border border-error/20">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @include('flash::message')

    <!-- Security Tip -->
    <div class="p-4 bg-surface-container-lowest rounded-2xl border border-primary/20 flex items-start gap-3 shadow-sm">
        <span class="material-symbols-outlined text-primary shrink-0 text-[20px] mt-0.5">verified_user</span>
        <p class="text-xs text-secondary leading-relaxed">
            Please confirm the beneficiary account details before authorizing. Transfers within <?= $confiG->bank_name ?? 'OripioFin' ?> execute in real-time with instant ledger finality.
        </p>
    </div>

    <!-- Transfer Form Card -->
    <div class="bg-surface-container-lowest rounded-2xl p-6 sm:p-8 border border-outline-variant/30 shadow-sm">
        <form id="form-wizard1" method="POST" action="{{ asset('initiate-same-bank-transfer') }}" class="space-y-5">
            <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>" />

            <!-- From Account -->
            <div>
                <label for="transfer_from" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Select Source Account</label>
                <select name="transfer_from" id="transfer_from" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-xs text-on-surface font-semibold focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none font-mono cursor-pointer transition-all">
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
                <div class="flex justify-between items-center mb-2">
                    <label for="beneficiary_account" class="block text-xs font-bold text-secondary uppercase tracking-wider">Select Registered Beneficiary</label>
                    <a href="{{ asset('add-beneficiaries') }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                        <span>+ Add New</span>
                    </a>
                </div>
                <select name="beneficiary_account" id="beneficiary_account" required class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-xs text-on-surface font-semibold focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none font-mono cursor-pointer transition-all">
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
                <label for="amount" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Amount to Transfer</label>
                <div class="relative rounded-2xl bg-surface-container-low border border-outline-variant/30 focus-within:border-primary focus-within:bg-surface-container-lowest focus-within:ring-2 focus-within:ring-primary/20 transition-all overflow-hidden p-3 sm:p-4">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-secondary">$</span>
                        <input type="text" name="amount" id="amount" required placeholder="0.00" class="w-full bg-transparent border-0 text-3xl sm:text-4xl font-extrabold text-on-surface font-sans focus:ring-0 p-0 outline-none">
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold text-secondary uppercase tracking-wider mb-2">Payment Reference / Description</label>
                <input type="text" name="description" id="description" placeholder="e.g. Commercial invoice settlement, consulting fee..." class="w-full bg-surface-container-low border border-outline-variant/30 rounded-xl px-4 py-3 text-xs text-on-surface focus:bg-surface-container-lowest focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
            </div>

            <!-- Submit -->
            <div class="pt-5 border-t border-surface-container flex flex-col sm:flex-row items-center justify-between gap-4">
                <span class="text-xs text-secondary font-medium">Zero Fee Intra-Bank Settlement</span>
                <button type="submit" id="submit-first-step-sb" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary hover:bg-primary-container text-on-primary text-xs font-bold transition-all shadow-md flex items-center justify-center gap-2">
                    <span>Continue to Authorization</span>
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
