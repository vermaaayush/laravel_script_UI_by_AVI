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
<div class="max-w-3xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-slate-400">Transfer</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Success</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Transfer Successful</h1>
        <p class="text-sm text-slate-500 mt-1">Instant internal transfer completed to <?= htmlspecialchars($confiG->bank_name ?? 'Bank') ?> account.</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden text-center p-8 sm:p-12 relative">
        <div class="w-24 h-24 rounded-full bg-emerald-50 border-4 border-emerald-100 flex items-center justify-center text-emerald-600 mx-auto mb-6 shadow-sm">
            <span class="material-symbols-outlined text-[48px]">check_circle</span>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-full text-xs font-bold tracking-wide uppercase mb-3">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Instant Settlement
        </span>

        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mb-2">Transfer Executed Successfully</h2>
        <p class="text-sm text-slate-500 max-w-md mx-auto mb-8">
            Your transfer to <?= htmlspecialchars($confiG->bank_name ?? 'Bank') ?> account has been processed instantly with zero clearance delay.
        </p>

        <form id="form-wizard1" method="POST" action="" class="hidden">
            @csrf
        </form>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-6 border-t border-slate-100 max-w-md mx-auto">
            <a href="{{ url('/transfer-to-same-bank') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[16px]">sync_alt</span> New Transfer
            </a>
            <a href="{{ url('/online') }}" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[16px]">dashboard</span> Return to Dashboard
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
