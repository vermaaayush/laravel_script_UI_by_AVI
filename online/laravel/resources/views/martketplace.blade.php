@php


    $user_id = session()->get('user_id');

$trans_data = DB::table('transactions')
    ->where('user_id', $user_id)
    ->where('subject', 'Fund Transfer')  // Add this where clause
    ->orderBy('created_at', 'desc')  // You can keep the ordering or remove it if you don't want it
    ->get();  // This will fetch all records for the given user_id and subject 'Fund Transfer'


    
    

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
<div class="max-w-7xl mx-auto w-full px-3">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-lg mt-4">
        <div>
            <h1 class="text-display-lg font-display-lg text-on-surface mb-xs">Cryptocurrency Marketplace</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Live market capitalization, heatmaps, and financials.</p>
        </div>
    </div>

     <div class="tradingview-widget-container mb-lg">
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
    
    <div class="mb-6">
        <h4 class="text-title-lg font-bold text-on-surface">Market Capitalization</h4>
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
    
    
<br>
<hr>


<br>
<!-- TradingView Widget BEGIN -->
<div style="margin: auto" class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-financials.js" async>
  {
  "isTransparent": false,
  "largeChartUrl": "",
  "displayMode": "regular",
  "width": 400,
  "height": 550,
  "colorTheme": "light",
  "symbol": "MARKETSCOM:BITCOIN",
  "locale": "en"
}
  </script>
</div>


<br>
<hr class="border-surface-container-high my-lg">
<br>
<div class="mb-6">
    <h4 class="text-title-lg font-bold text-on-surface">Birds-eye view of crypto market cap, recent performance and more.</h4>
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
"height": "550"
}
</script>
</div>
     
</div>
<!-- // Page Content -->
      
<!-- footer -->
@include('footer')
<!-- // footer -->
