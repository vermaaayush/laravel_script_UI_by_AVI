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
    $content = DB::table('ba_extras')->where('id','1')->first(); 
?>

<!-- Main Content Wrapper -->
<div class="max-w-5xl mx-auto w-full pb-16">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Dashboard
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('loan-summary') }}">Loans</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Apply</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Financing & Credit Facilities</h1>
        <p class="text-sm text-slate-500 mt-1">Unlock competitive personal, mortgage, and business loans designed around your life.</p>
    </div>

    <!-- Architectural Hero Banner -->
    <div class="bg-gradient-to-br from-[#10141e] via-[#171c28] to-[#0c0f17] rounded-3xl text-white p-8 sm:p-12 border border-slate-800 shadow-2xl relative overflow-hidden mb-8">
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-primary/20 blur-3xl pointer-events-none"></div>
        <div class="absolute right-0 bottom-0 w-96 h-96 opacity-10 pointer-events-none">
            <span class="material-symbols-outlined text-[360px] text-white">real_estate_agent</span>
        </div>

        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary/20 text-primary border border-primary/30 mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span> Tailored Lending Rates
            </span>
            <h2 class="text-3xl sm:text-4xl font-black tracking-tight mb-4">Empowering Your Ambition With Flexible Credit</h2>
            
            <div class="text-sm text-slate-300 leading-relaxed space-y-2 mb-8">
                @if($content && $content->loan_landing_text)
                    <?= $content->loan_landing_text ?>
                @else
                    <p>Whether you're purchasing your dream home, acquiring equipment for business expansion, or consolidating liabilities, our lending packages offer structured tenures and low APRs.</p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                <a href="{{ asset('request-loan-form') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-2xl shadow-lg shadow-primary/25 transition-all duration-200 hover:-translate-y-0.5">
                    <span>Start Online Application</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
                <a href="{{ url('loan-summary') }}" class="inline-flex items-center justify-center gap-2 px-6 py-4 bg-white/10 hover:bg-white/15 text-white text-xs font-bold uppercase tracking-wider rounded-2xl border border-white/10 backdrop-blur-sm transition-colors">
                    View Existing Loans
                </a>
            </div>
        </div>
    </div>

    <!-- Feature Pillars -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[24px]">percent</span>
            </div>
            <div>
                <h4 class="text-base font-bold text-slate-900 mb-1">Competitive Interest Rates</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Enjoy institutional-grade financing rates with fixed or floating options tailored to your risk profile.</p>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[24px]">speed</span>
            </div>
            <div>
                <h4 class="text-base font-bold text-slate-900 mb-1">Fast Approval Clearance</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Digital document submission and automated underwriting allow for rapid decisioning within 48 business hours.</p>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-600 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[24px]">calendar_month</span>
            </div>
            <div>
                <h4 class="text-base font-bold text-slate-900 mb-1">Flexible Tenures</h4>
                <p class="text-xs text-slate-500 leading-relaxed">Select repayment horizons from 6 up to 120 months with customizable amortization and early clearance options.</p>
            </div>
        </div>
    </div>
</div>

<!-- footer -->
@include('footer')
<!-- // footer -->
