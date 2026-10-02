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
<div class="max-w-2xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('manage-beneficiaries') }}">Manage Beneficiaries</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Registered</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Beneficiary Registered</h1>
        <p class="text-sm text-slate-500 mt-1">Recipient created in directory. Verification required before transfers can be executed.</p>
    </div>

    @include('flash::message')

    <!-- Success Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-10 text-center relative overflow-hidden" id="mapAfteraccount">
        <div class="w-20 h-20 rounded-full bg-emerald-50 border-4 border-emerald-100 flex items-center justify-center text-emerald-600 mx-auto mb-6 shadow-sm">
            <span class="material-symbols-outlined text-[42px]">check_circle</span>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-full text-xs font-bold tracking-wide uppercase mb-3">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Recorded In Directory
        </span>

        <h2 class="text-2xl font-black text-slate-900 mb-2">Recipient Profile Created</h2>
        <p class="text-sm text-slate-500 max-w-sm mx-auto mb-8">
            Review the details below and proceed with one-time security authentication.
        </p>

        <div class="bg-slate-50/70 border border-slate-200/80 rounded-2xl p-6 text-left max-w-md mx-auto mb-8 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200/60">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Account Title</span>
                <span class="text-sm font-bold text-slate-900">{{ $Ba_beneficiary->account->account_title ?? 'Recipient' }}</span>
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-slate-200/60">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Account Number</span>
                <span class="text-sm font-mono font-bold text-slate-800">{{ $Ba_beneficiary->beneficiary_account }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</span>
                @if($Ba_beneficiary->verification == 1)
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Verified
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending Verification
                    </span>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-center">
            <a href="{{ asset('email-verification') }}/{{$Ba_beneficiary->id}}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200">
                <span>Proceed to Verification</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
