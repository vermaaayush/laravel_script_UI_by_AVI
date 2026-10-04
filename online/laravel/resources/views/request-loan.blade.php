<!-- Header -->
@include('header')
<!-- Sidebar -->
@include('sidebar')
<!-- top navbar -->
@include('topNav')

<?php 
    $content = DB::table('ba_extras')->where('id','1')->first(); 
?>

<!-- Main Content Wrapper (Stitch Sovereign Theme) -->
<div class="max-w-5xl mx-auto w-full pb-16 font-sans">
    <!-- Breadcrumb & Header -->
    <div class="mb-8">
        <div class="flex items-center gap-2 text-secondary text-xs font-semibold uppercase tracking-wider mb-2">
            <a class="hover:text-primary transition-colors flex items-center gap-1" href="{{ url('/online') }}">
                <span class="material-symbols-outlined text-[16px]">home</span> Overview
            </a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <a class="hover:text-primary transition-colors" href="{{ url('loan-summary') }}">Credit Facilities</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-bold">Apply</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-heading font-bold text-on-surface tracking-tight">Financing & Credit Facilities</h1>
        <p class="text-sm text-secondary mt-1">Unlock competitive institutional liquidity, debt restructuring, and commercial term facilities.</p>
    </div>

    <!-- Architectural Hero Banner (Stitch Sovereign Emerald Style) -->
    <div class="bg-gradient-to-br from-[#002111] via-primary to-primary-container rounded-3xl text-on-primary p-8 sm:p-12 border border-white/10 shadow-2xl relative overflow-hidden mb-8">
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-primary-fixed/15 blur-3xl pointer-events-none"></div>
        <div class="absolute right-0 bottom-0 w-96 h-96 opacity-10 pointer-events-none">
            <span class="material-symbols-outlined text-[360px] text-white">real_estate_agent</span>
        </div>

        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-white/10 text-primary-fixed border border-white/10 mb-4 backdrop-blur-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-tertiary-fixed animate-pulse"></span> Tailored Sovereign Lending Rates
            </span>
            <h2 class="text-3xl sm:text-4xl font-heading font-bold tracking-tight mb-4 text-white">
                Empowering Sovereign Capital With Flexible Debt Facilities
            </h2>
            
            <div class="text-sm text-white/80 leading-relaxed space-y-2 mb-8">
                @if($content && $content->loan_landing_text)
                    <?= $content->loan_landing_text ?>
                @else
                    <p>Whether you're acquiring commercial real estate, funding operational working capital, or consolidating international credit lines, our facilities offer structured tenures and low spreads.</p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                <a href="{{ asset('request-loan-form') }}" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-primary-fixed hover:bg-primary-fixed-dim text-primary text-xs font-bold uppercase tracking-wider rounded-full shadow-lg transition-all duration-200">
                    <span>Start Facility Application</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
                <a href="{{ url('loan-summary') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white text-xs font-bold uppercase tracking-wider rounded-full border border-white/15 backdrop-blur-sm transition-colors">
                    View Existing Facilities
                </a>
            </div>
        </div>
    </div>

    <!-- Feature Pillars -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-6 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex flex-col justify-between">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[24px]">percent</span>
            </div>
            <div>
                <h4 class="text-base font-heading font-bold text-on-surface mb-1">Competitive Benchmark Rates</h4>
                <p class="text-xs text-secondary leading-relaxed">Enjoy institutional borrowing rates tied to SOFR / EURIBOR benchmarks tailored to your treasury risk profile.</p>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex flex-col justify-between">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[24px]">speed</span>
            </div>
            <div>
                <h4 class="text-base font-heading font-bold text-on-surface mb-1">Fast Underwriting Clearance</h4>
                <p class="text-xs text-secondary leading-relaxed">Automated document verification and senior risk committee decisioning within 48 business hours.</p>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex flex-col justify-between">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[24px]">calendar_month</span>
            </div>
            <div>
                <h4 class="text-base font-heading font-bold text-on-surface mb-1">Flexible Amortization Tenures</h4>
                <p class="text-xs text-secondary leading-relaxed">Select repayment horizons from 6 up to 120 months with bullet, amortizing, and customized interest-only tranches.</p>
            </div>
        </div>
    </div>
</div>

@include('footer')
