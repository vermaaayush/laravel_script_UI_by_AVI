<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
?>

@include('flash::message')
@if ($errors->any())
    <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-xs">
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ asset('add-beneficary') }}" class="space-y-5">
    @csrf
    
    <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/80">
        <label for="bank_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
            Select Destination Type <span class="text-rose-500">*</span>
        </label>
        <div class="relative">
            <select onChange="fetch_data_modal(this.value)" id="bank_type" name="bank_type" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                <option value="" selected disabled>Select Bank Type</option>
                <option value="1"><?= $confiG->bank_name ?? 'Equitable Bank' ?> (Internal Account)</option>
                <option value="0">Other Bank (Foreign / External Wire)</option>
            </select>
            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
        </div>
    </div>

    <!-- Account Number -->
    <div style="display:none;" id="beneficiary_account">
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Account Number <span class="text-rose-500">*</span></label>
        <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-mono font-semibold text-slate-800 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="beneficiary_account" id="beneficiary_account1" required value="{{ old('beneficiary_account') }}" placeholder="Account Number" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Beneficiary Name -->
        <div style="display:none;" id="beneficiary_name">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Beneficiary Name <span class="text-rose-500">*</span></label>
            <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="beneficiary_name" id="beneficiary_name1" required value="{{ old('beneficiary_name') }}" placeholder="Official recipient name" />
        </div>

        <!-- Beneficiary Address -->
        <div style="display:none;" id="beneficiary_address">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Beneficiary Address <span class="text-rose-500">*</span></label>
            <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="beneficiary_address" id="beneficiary_address1" required value="{{ old('beneficiary_address') }}" placeholder="Street address, city" />
        </div>

        <!-- Bank Name -->
        <div style="display:none;" id="beneficiary_bank_name">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Beneficiary Bank Name <span class="text-rose-500">*</span></label>
            <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="beneficiary_bank_name" id="beneficiary_bank_name1" required value="{{ old('beneficiary_bank_name') }}" placeholder="Bank name" />
        </div>

        <!-- Country -->
        <div style="display:none;" id="beneficiary_country">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Bank Country <span class="text-rose-500">*</span></label>
            <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="beneficiary_country" id="beneficiary_country1" required value="{{ old('beneficiary_country') }}" placeholder="Country" />
        </div>

        <!-- Branch Address -->
        <div style="display:none;" id="beneficiary_bank_address" class="sm:col-span-2">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Bank Branch Address <span class="text-rose-500">*</span></label>
            <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="beneficiary_bank_address" id="beneficiary_bank_address1" required value="{{ old('beneficiary_bank_address') }}" placeholder="Branch address, city, postal code" />
        </div>

        <!-- Routing / Sort code -->
        <div style="display:none;" id="beneficiary_sort_code">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Routing / Sort code</label>
            <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-mono font-semibold text-slate-800 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="beneficiary_sort_code" value="{{ old('beneficiary_sort_code') }}" placeholder="Routing / Sort code" />
        </div>

        <!-- Swift Code -->
        <div style="display:none;" id="beneficiary_swift">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">SWIFT / BIC</label>
            <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-mono font-semibold text-slate-800 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="beneficiary_swift" value="{{ old('beneficiary_swift') }}" placeholder="SWIFT / BIC" />
        </div>

        <!-- IBAN -->
        <div style="display:none;" id="beneficiary_iban" class="sm:col-span-2">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">IBAN</label>
            <input type="text" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-mono font-semibold text-slate-800 focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all" name="beneficiary_iban" value="{{ old('beneficiary_iban') }}" placeholder="IBAN" />
        </div>
    </div>

    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
        <button type="submit" class="px-7 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            <span>Add Beneficiary</span>
        </button>
    </div>
</form>

<script>
function fetch_data_modal(type) {  
    if(type == '1') {
        $('#beneficiary_account').show();
        $("#beneficiary_account").addClass("accountz");
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
        $("#beneficiary_account").removeClass("accountz");
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
