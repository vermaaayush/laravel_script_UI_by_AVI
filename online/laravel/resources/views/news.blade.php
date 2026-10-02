

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
            <h1 class="text-display-lg font-display-lg text-on-surface mb-xs">Cryptocurrency Market News</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant">Stay updated with the latest news in the crypto world.</p>
        </div>
    </div>
    
    <div>
        
                         <!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container" style="margin:auto">
  <div class="tradingview-widget-container__widget"></div>

  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
  {
  "feedMode": "market",
  "isTransparent": false,
  "displayMode": "regular",
  "width": "100%",
  "height": 550,
  "colorTheme": "light",
  "locale": "en",
  "market": "crypto"
}
  </script>
</div>
<!-- TradingView Widget END -->
        
        <br>
        
        <br>
        
        <br>
                 
                
                
                
</div>
<!-- // Page Content -->
      
<!-- footer -->
@include('footer')
<!-- // footer -->
