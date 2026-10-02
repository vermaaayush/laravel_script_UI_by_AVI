<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- //  Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
?>

<!-- Main Content Wrapper -->
<div class="max-w-2xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Transfer</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Verification Passed</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Security Check Passed</h1>
        <p class="text-sm text-slate-500 mt-1">Multi-factor authorization code verified successfully.</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 sm:p-12 text-center relative overflow-hidden">
        <div class="w-20 h-20 rounded-full bg-emerald-50 border-4 border-emerald-100 flex items-center justify-center text-emerald-600 mx-auto mb-6 shadow-sm">
            <span class="material-symbols-outlined text-[42px]">verified_user</span>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-full text-xs font-bold tracking-wide uppercase mb-3">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> OTP Confirmed
        </span>

        <h2 class="text-2xl font-black text-slate-900 mb-2">Your Code Has Been Matched</h2>
        <p class="text-sm text-slate-500 max-w-sm mx-auto mb-8">
            Security validation was authenticated. Please proceed to finalize the external wire clearance workflow.
        </p>

        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/60 max-w-md mx-auto mb-8 flex items-center justify-between text-left">
            <div>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Wire Transmission ID</span>
                <span class="text-sm font-mono font-bold text-slate-800">{{ $tran_id }}</span>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-slate-600">
                Step {{ $step }} Clearance
            </span>
        </div>

        <div class="flex items-center justify-center">
            <a href="{{ url('other-bank-transfer-otp-new/' . $tran_id . '/' . $step) }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-200 w-full sm:w-auto">
                <span>Complete Process</span>
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>
    </div>
</div>
<!-- // Page Content -->

<script>
    function openModal(id){
        $('.bankPopup'+id).modal('show');
    }
</script>

<!-- footer -->
@include('footer')
<!-- // footer -->
