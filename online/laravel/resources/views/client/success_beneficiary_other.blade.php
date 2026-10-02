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
            <span class="text-primary font-bold">External Registered</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">External Beneficiary Registered</h1>
        <p class="text-sm text-slate-500 mt-1">Review your foreign or third-party wire beneficiary details below.</p>
    </div>

    @include('flash::message')

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-10 relative overflow-hidden" id="mapAfteraccount">
        <div class="flex items-center justify-between pb-6 border-b border-slate-100 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 border border-primary/20 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[26px]">public</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">{{ $Ba_beneficiary->beneficiary_name }}</h3>
                    <p class="text-xs text-slate-500">{{ $Ba_beneficiary->beneficiary_bank_name }} &bull; {{ $Ba_beneficiary->beneficiary_country }}</p>
                </div>
            </div>
            <div>
                @if($Ba_beneficiary->verification == 1)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Verified
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Verification Pending
                    </span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mb-8">
            <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Account Number</p>
                <p class="text-sm font-mono font-bold text-slate-900">{{ $Ba_beneficiary->beneficiary_account }}</p>
            </div>
            <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">SWIFT Code / BIC</p>
                <p class="text-sm font-mono font-bold text-slate-900">{{ $Ba_beneficiary->beneficiary_swift ?? 'N/A' }}</p>
            </div>
            <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Routing / Sort Code</p>
                <p class="text-sm font-mono font-bold text-slate-900">{{ $Ba_beneficiary->beneficiary_sort_code ?? 'N/A' }}</p>
            </div>
            <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60 sm:col-span-2">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">IBAN</p>
                <p class="text-sm font-mono font-bold text-slate-900">{{ $Ba_beneficiary->beneficiary_iban ?? 'N/A' }}</p>
            </div>
            <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Bank Country</p>
                <p class="text-sm font-bold text-slate-900">{{ $Ba_beneficiary->beneficiary_country }}</p>
            </div>
            <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60 sm:col-span-2 md:col-span-3">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Beneficiary Address</p>
                <p class="text-sm text-slate-800">{{ $Ba_beneficiary->beneficiary_address }}</p>
            </div>
            <div class="p-4 bg-slate-50/70 rounded-2xl border border-slate-200/60 sm:col-span-2 md:col-span-3">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Bank Branch Address</p>
                <p class="text-sm text-slate-800">{{ $Ba_beneficiary->beneficiary_bank_address }}</p>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="{{ url('manage-beneficiaries') }}" class="px-5 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                Back to Directory
            </a>
            @if($Ba_beneficiary->verification != 1)
                <a href="{{ asset('email-verification') }}/{{$Ba_beneficiary->id}}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200">
                    <span>Complete Email Verification</span>
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                </a>
            @endif
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
