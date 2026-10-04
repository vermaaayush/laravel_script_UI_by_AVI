@php
    $user_id = session()->get('user_id');

    $trans_data = DB::table('transactions')
        ->where('user_id', $user_id)
        ->where('subject', 'Fund Transfer')
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

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
<div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-[#53625b] uppercase tracking-wider mb-2">
                <a class="hover:text-[#004226] transition-colors" href="{{ url('/') }}">Custody Portal</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-[#191c1c] font-bold">Exchange Intelligence</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-headline text-[#191c1c] tracking-tight">Cryptocurrency Capitalization & Heatmap</h1>
            <p class="text-sm text-[#53625b] mt-1">Live market telemetry, global liquidity capitalization, and market screening.</p>
        </div>
    </div>

    <div class="tradingview-widget-container rounded-2xl overflow-hidden border border-[#e6e9e8] shadow-sm bg-white p-2">
        <div class="tradingview-widget-container__widget"></div>

        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
            {
                "symbols": [{
                        "proName": "BITSTAMP:BTCUSD",
                        "title": "Bitcoin"
                    },
                    {
                        "description": "BTC",
                        "proName": "CME:BTC1!"
                    },
                    {
                        "description": "ETH",
                        "proName": "MARKETSCOM:ETHEREUM"
                    },
                    {
                        "description": "ETHF",
                        "proName": "CME:ETH1!"
                    },
                    {
                        "description": "USDT",
                        "proName": "CRYPTOCAP:USDT"
                    },
                    {
                        "description": "USDT.D",
                        "proName": "CRYPTOCAP:USDT.D"
                    }
                ],
                "showSymbolLogo": true,
                "isTransparent": false,
                "displayMode": "adaptive",
                "colorTheme": "light",
                "locale": "en"
            }
        </script>
    </div>
    
    <div class="bg-white rounded-2xl p-6 border border-[#e6e9e8] shadow-sm">
        <div class="mb-4">
            <h3 class="text-base font-bold font-headline text-[#191c1c]">Global Asset Screener</h3>
            <p class="text-xs text-[#53625b]">Institutional market cap rankings, 24h delta, and technical indicators.</p>
        </div>
        
        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-screener.js" async>
            {
                "width": "100%",
                "height": 550,
                "defaultColumn": "overview",
                "screener_type": "crypto_mkt",
                "displayCurrency": "USD",
                "colorTheme": "light",
                "locale": "en"
            }
            </script>
        </div>
        <!-- TradingView Widget END -->
    </div>

    <div class="bg-white rounded-2xl p-6 border border-[#e6e9e8] shadow-sm">
        <div class="mb-4">
            <h3 class="text-base font-bold font-headline text-[#191c1c]">Liquidity & Volatility Heatmap</h3>
            <p class="text-xs text-[#53625b]">Birds-eye distribution of crypto market cap weighted by trading volume.</p>
        </div>
        
        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-crypto-coins-heatmap.js" async>
            {
                "dataSource": "Crypto",
                "blockSize": "24h_vol_cmc",
                "blockColor": "change|60",
                "locale": "en",
                "symbolUrl": "",
                "colorTheme": "light",
                "hasTopBar": false,
                "isDataSetEnabled": false,
                "isZoomEnabled": true,
                "hasSymbolTooltip": true,
                "isMonoSize": false,
                "width": "100%",
                "height": 550
            }
            </script>
        </div>
    </div>
</div>
<!-- // Page Content -->
      
<!-- footer -->
@include('footer')
<!-- // footer -->
