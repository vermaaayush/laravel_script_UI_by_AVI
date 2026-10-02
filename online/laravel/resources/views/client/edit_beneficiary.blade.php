<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- // Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

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
            <span class="text-primary font-bold">Edit Beneficiary</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Edit External Beneficiary</h1>
        <p class="text-sm text-slate-500 mt-1">Update counterparty information for external or foreign wire transfers.</p>
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
        <form method="POST" action="{{ asset('update-beneficary') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="id" value="{{$Ba_beneficiary->id}}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Beneficiary Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Beneficiary Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_name" required value="{{$Ba_beneficiary->beneficiary_name}}" placeholder="Recipient Name" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Account Number -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Account Number <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_account" required value="{{$Ba_beneficiary->beneficiary_account}}" placeholder="Account Number" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Beneficiary Address -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Beneficiary Address <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_address" required value="{{$Ba_beneficiary->beneficiary_address}}" placeholder="Street address, City" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Bank Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bank Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_bank_name" required value="{{$Ba_beneficiary->beneficiary_bank_name}}" placeholder="Beneficiary Bank Name" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Bank Country -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bank Country <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_country" required value="{{$Ba_beneficiary->beneficiary_country}}" placeholder="Beneficiary Country" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Bank Address -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bank Address <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_bank_address" required value="{{$Ba_beneficiary->beneficiary_bank_address}}" placeholder="Branch Address" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Sort Code -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Routing / Sort Code <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_sort_code" required value="{{$Ba_beneficiary->beneficiary_sort_code}}" placeholder="Routing / Sort code" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- Swift Code -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Swift Code / BIC <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_swift" required value="{{$Ba_beneficiary->beneficiary_swift}}" placeholder="SWIFT / BIC" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>

                <!-- IBAN -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">IBAN (IBAN Beneficiary Only) <span class="text-rose-500">*</span></label>
                    <input type="text" name="beneficiary_iban" required value="{{$Ba_beneficiary->beneficiary_iban}}" placeholder="IBAN number" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-mono font-semibold focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all">
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('manage-beneficiaries') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span> Update Beneficiary
                </button>
            </div>
        </form>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
