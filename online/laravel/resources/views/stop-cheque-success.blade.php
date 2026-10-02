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
            <span class="text-slate-400">Cheques</span>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Stop Order Placed</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Stop Cheque Registered</h1>
        <p class="text-sm text-slate-500 mt-1">Stop payment order has been accepted and recorded on the clearing ledger.</p>
    </div>

    <!-- Success Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-8 sm:p-12 text-center relative overflow-hidden">
        <div class="w-20 h-20 rounded-full bg-emerald-50 border-4 border-emerald-100 flex items-center justify-center text-emerald-600 mx-auto mb-6 shadow-sm">
            <span class="material-symbols-outlined text-[42px]">check_circle</span>
        </div>

        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200/60 rounded-full text-xs font-bold tracking-wide uppercase mb-3">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Stop-Order Active
        </span>

        <h2 class="text-2xl font-black text-slate-900 mb-2">Stop Cheque Requested Successfully</h2>
        <p class="text-sm text-slate-500 max-w-sm mx-auto mb-8">
            The clearinghouse and teller network have been alerted. Any presentation of the specified cheques will be rejected automatically.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-6 border-t border-slate-100">
            <a href="{{ url('stop-cheque') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                Stop Another Cheque
            </a>
            <a href="{{ url('/online') }}" class="w-full sm:w-auto px-8 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[16px]">dashboard</span> Return to Dashboard
            </a>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
