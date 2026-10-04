<!-- Header -->
@include('header')
<!-- // Header -->

<!-- Sidebar -->
@include('sidebar')
<!-- //  Sidebar -->

<!-- top navbar -->
@include('topNav')
<!-- // top navbar -->

<!-- Page Content  -->
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
                <a class="hover:text-[#004226] transition-colors" href="{{ url('/') }}">Custody Portal</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#191c1c] font-bold">Market Intelligence</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Financial & Digital Asset News</h1>
            <p class="text-sm text-[#53625b] mt-1">Real-time regulatory disclosures, central bank announcements, and institutional cryptocurrency wires.</p>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl p-6 border border-[#e6e9e8] shadow-sm">
        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container" style="margin:auto">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
            {
                "feedMode": "market",
                "isTransparent": false,
                "displayMode": "regular",
                "width": "100%",
                "height": 600,
                "colorTheme": "light",
                "locale": "en",
                "market": "crypto"
            }
            </script>
        </div>
        <!-- TradingView Widget END -->
    </div>
</div>
<!-- // Page Content -->
      
<!-- footer -->
@include('footer')
<!-- // footer -->
