<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- // Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
?>

<!-- Main Content Wrapper -->
<div class="max-w-4xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('manage-beneficiaries') }}">Manage Beneficiaries</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Add Beneficiary</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Add New Beneficiary</h1>
        <p class="text-sm text-slate-500 mt-1">Register internal account holders or external wire counterparty information.</p>
    </div>

    @include('flash::message')
    @if ($errors->any())
    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ asset('add-beneficary') }}" class="space-y-6">
            @csrf

            <!-- Bank Type Selector -->
            <div class="p-5 bg-slate-50/70 rounded-2xl border border-slate-200/80">
                <label for="bank_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Select Transfer Destination Type <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select id="bank_type" name="bank_type" onChange="fetch_data(this.value)" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="" selected disabled>Select Bank Destination Type</option>
                        <option value="1"><?= htmlspecialchars($confiG->bank_name ?? 'Bank') ?> (Internal Account Transfer)</option>
                        <option value="0">Other Bank (External / International Wire)</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                </div>
                <p class="text-xs text-slate-400 mt-2">Choose whether the counterparty has an account within this bank or at a third-party financial institution.</p>
            </div>

            <!-- Dynamic Beneficiary Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Account Number (Common) -->
                <div id="beneficiary_account" style="display:none;" class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Account Number <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_account" id="beneficiary_account1" required value="{{ old('beneficiary_account') }}" placeholder="e.g. 1029384756" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Beneficiary Name -->
                <div id="beneficiary_name" style="display:none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Beneficiary Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_name" id="beneficiary_name1" value="{{ old('beneficiary_name') }}" placeholder="Official recipient name" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Beneficiary Address -->
                <div id="beneficiary_address" style="display:none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Beneficiary Residential Address <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_address" id="beneficiary_address1" value="{{ old('beneficiary_address') }}" placeholder="Street address, City" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Beneficiary Bank Name -->
                <div id="beneficiary_bank_name" style="display:none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Beneficiary Bank Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_bank_name" id="beneficiary_bank_name1" value="{{ old('beneficiary_bank_name') }}" placeholder="e.g. JPMorgan Chase, Barclays" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Beneficiary Bank Country -->
                <div id="beneficiary_country" style="display:none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bank Country <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_country" id="beneficiary_country1" value="{{ old('beneficiary_country') }}" placeholder="e.g. United States, United Kingdom" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Beneficiary Bank Address -->
                <div id="beneficiary_bank_address" style="display:none;" class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bank Branch Address <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_bank_address" id="beneficiary_bank_address1" value="{{ old('beneficiary_bank_address') }}" placeholder="Branch address, City, Postal Code" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Routing / Sort code -->
                <div id="beneficiary_sort_code" style="display:none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bank Routing / Sort Code</label>
                    <input type="text" name="beneficiary_sort_code" value="{{ old('beneficiary_sort_code') }}" placeholder="ABA / Sort Code (optional)" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Swift Code / BIC -->
                <div id="beneficiary_swift" style="display:none;">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">SWIFT Code / BIC</label>
                    <input type="text" name="beneficiary_swift" value="{{ old('beneficiary_swift') }}" placeholder="e.g. CHASUS33XXX" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- IBAN -->
                <div id="beneficiary_iban" style="display:none;" class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">IBAN (International Bank Account Number)</label>
                    <input type="text" name="beneficiary_iban" value="{{ old('beneficiary_iban') }}" placeholder="e.g. GB29NWBK60161331926819" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('manage-beneficiaries') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span> Save Beneficiary
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function fetch_data(type) {
    if (type == '1') {
        $('#beneficiary_account').show();
        $('#beneficiary_name1').removeAttr('required');
        $('#beneficiary_name').hide();
        $('#beneficiary_address1').removeAttr('required');
        $('#beneficiary_address').hide();
        $('#beneficiary_sort_code').hide();
        $('#beneficiary_swift').hide();
        $('#beneficiary_iban').hide();
        $('#beneficiary_bank_name1').removeAttr('required');
        $('#beneficiary_bank_name').hide();
        $('#beneficiary_bank_address1').removeAttr('required');
        $('#beneficiary_bank_address').hide();
        $('#beneficiary_country1').removeAttr('required');
        $('#beneficiary_country').hide();
    } else {
        $('#beneficiary_account').show();
        $('#beneficiary_name').show();
        $('#beneficiary_address').show();
        $('#beneficiary_sort_code').show();
        $('#beneficiary_swift').show();
        $('#beneficiary_iban').show();
        $('#beneficiary_bank_name').show();
        $('#beneficiary_bank_address').show();
        $('#beneficiary_country').show();
    }
}
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
