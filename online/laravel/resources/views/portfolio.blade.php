 <!-- Header -->
 @include('header')
 <!-- // Header -->

 <!-- Sidebar -->
@include('sidebar')
 <!-- //  Sidebar -->

 <!-- top navbar -->
@include('topNav')
 <!-- // top navbar -->

@php
    $user_id = session()->get('user_id');


    $trans_data = DB::table('transactions')
    ->where('user_id', $user_id)
    ->orderBy('created_at', 'desc')
    ->take(10)
    ->get();


    $wallets = DB::table('wallets')->where('user_id', $user_id)->get();

    $displayWallets = collect();

    // BTC
    $btcWallet = $wallets->where('currency', 'btc')->first();
    if ($btcWallet || floatval($btc_fund ?? 0) > 0) {
        $displayWallets->push((object)[
            'id' => $btcWallet->id ?? 'btc_default',
            'currency' => 'btc',
            'fund' => floatval($btc_fund ?? 0),
            'address' => $btcWallet->address ?? '',
            'qr' => $btcWallet->qr ?? ''
        ]);
    }

    // USDT
    $usdtWallet = $wallets->where('currency', 'usdttrc20')->first();
    if ($usdtWallet || floatval($usdt_fund ?? 0) > 0) {
        $displayWallets->push((object)[
            'id' => $usdtWallet->id ?? 'usdt_default',
            'currency' => 'usdttrc20',
            'fund' => floatval($usdt_fund ?? 0),
            'address' => $usdtWallet->address ?? '',
            'qr' => $usdtWallet->qr ?? ''
        ]);
    }

    // Fallback: If no wallets created and no funds set yet, show default BTC wallet entry so user sees BTC balance card
    if ($displayWallets->isEmpty()) {
        $displayWallets->push((object)[
            'id' => 'btc_default',
            'currency' => 'btc',
            'fund' => floatval($btc_fund ?? 0),
            'address' => '',
            'qr' => ''
        ]);
    }

    $walletData = [
        'btc' => [
            'wallet' => $btcWallet,
            'fund' => $btc_fund
        ],
        'usdt' => [
            'wallet' => $usdtWallet,
            'fund' => $usdt_fund
        ],
    ];

@endphp
   <div id="content-page" class="content-page" >
            <div class="max-w-7xl mx-auto w-full">

     <div class="tradingview-widget-container">
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
      <br>


                   
                   




                 

                  <div class="flex flex-col lg:flex-row gap-6 mb-6">

                  <div class="w-full lg:w-1/2 flex flex-col">
                      
    <div class="bg-gradient-to-br from-[#0f131a] to-[#1a2230] text-white rounded-2xl shadow-md border border-slate-800 h-full overflow-hidden flex flex-col transition-all duration-300">
        <div class="card-body text-center p-0 overflow-hidden flex flex-col h-full">
            <div class="p-6 border-b border-white/10 flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px] text-[#c59b27]">account_balance_wallet</span>
                    Portfolio Valuation
                </span>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Live Feed
                </span>
            </div>
            <div class="px-6 py-6">
                <p class="text-xs text-slate-400 uppercase font-semibold tracking-wider mb-1">Total Estimated Value</p>
                <p id="total_live_wallet_balance" class="text-3xl sm:text-4xl font-extrabold font-mono text-white mb-4 tracking-tight">$0.00</p>

                @if (!$walletData['btc']['wallet'] || !$walletData['usdt']['wallet'] || (isset($walletData['eth']) && !$walletData['eth']['wallet']))
                <button class="bg-[#c59b27] hover:bg-[#b0871d] text-black font-bold text-xs px-4 py-2 rounded-xl transition-all shadow-sm flex items-center gap-1.5 mx-auto" data-bs-toggle="modal" data-bs-target="#addWallet">
                    + New Asset Wallet
                </button>
                @endif
            </div>

             <!---  wallets balance -->

              <?php

                  $wallets = DB::table('wallets')->where('user_id', $user_id)->get();

                                                                                // Fetch live prices once
                  $cacheFile = storage_path('app/cache/coin_gecko_rates.json'); // Use storage path
                  $cacheTime = 3600;                                            // 1 hour

                  // Create the cache directory if it doesn't exist
                  if (! file_exists(dirname($cacheFile))) {
                      mkdir(dirname($cacheFile), 0755, true);
                  }

                  if (file_exists($cacheFile) && time() - $cacheTime < filemtime($cacheFile)) {
                      // Use cached data
                      $rates = json_decode(file_get_contents($cacheFile), true);
                  } else {
                      // Make API request
                      $apiUrl   = 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,tether&vs_currencies=usd';
                      $response = @file_get_contents($apiUrl);

                      if ($response !== false) {
                          $rates = json_decode($response, true);
                          // Cache the response
                          file_put_contents($cacheFile, json_encode($rates));
                      } else {
                          // Handle error (API request failed)
                          echo 'Unable to fetch data from API.';
                          // Optionally, you can load cached data here if available
                      }
                  }

              ?>


                                <?php foreach ($displayWallets as $wallet):
                                        $currency = strtolower($wallet->currency);
                                        $fundAmount = $wallet->fund;
                                        $currencyDisplay = $wallet->currency === 'usdttrc20' ? 'USDT TRC20' : strtoupper($wallet->currency);
                                    ?>
			                                <div class="bg-white/5 border border-white/10 text-white p-4 rounded-xl mb-3 mx-6 text-left">
			                                  <div class="flex items-center justify-between">
                                                <div>
                                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $currencyDisplay }} Balance</span>
                                                    <h6 class="text-base font-bold font-mono text-white mt-0.5">
                                                        <span id="amount-{{ $wallet->id }}">{{ $fundAmount }}</span>
                                                    </h6>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-[10px] text-slate-400 uppercase font-semibold">USD Valuation</span>
                                                    <h6 id="trade-value-{{ $wallet->id }}" class="text-sm font-bold font-mono text-emerald-400 mt-0.5">
                                                        $0.00
                                                    </h6>
                                                </div>
                                            </div>
                                            </div>
                                <?php endforeach; ?>

        </div>
    </div>
</div>

<div class="w-full lg:w-1/2 flex flex-col">

                      <div class="h-full">
    <div class="glass-panel rounded-2xl soft-shadow-hover h-full overflow-hidden p-6 transition-all duration-300">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-6" id="cryptoTabs">
            <!--<li class="nav-item">-->
            <!--    <a class="nav-link active fw-bold text-dark" id="buy-tab" data-bs-toggle="tab" href="#buyForm">Buy</a>-->
            <!--</li>-->
            <!--<li class="nav-item">-->
            <!--    <a class="nav-link fw-bold text-dark" id="sell-tab" data-bs-toggle="tab" href="#sellForm">Sell</a>-->
            <!--</li>-->
            <li class="nav-item">
                <a class="nav-link fw-bold text-dark" id="send-tab" data-bs-toggle="tab" href="#sendForm">Send</a>
            </li>
           <li class="nav-item">
    <a class="nav-link fw-bold text-dark" id="receive-tab" data-bs-toggle="tab" href="#receiveForm" onclick="openTab()">Receive</a>
</li>

        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Buy Form -->
            <div class="tab-pane fade show " id="buyForm">
                <h5 class="fw-semibold">Estimated Purchase Value</h5>
                <div class="input-group mb-6">
                    <input type="text" class="form-control bg-light border" placeholder="Value">
                    <span class="input-group-text bg-light border">BTC</span>
                </div>
                <h5 class="fw-semibold">Trade Value</h5>
                <div class="input-group mb-6">
                    <input type="text" class="form-control bg-light border" placeholder="Value">
                    <span class="input-group-text bg-light border">USD</span>
                </div>
                <button class="btn btn-success w-100">Buy BTC</button>
            </div>

            <!-- Sell Form -->
            <div class="tab-pane fade" id="sellForm">
                <h5 class="fw-semibold">Sell Amount</h5>
                <div class="input-group mb-6">
                    <input type="text" class="form-control bg-light border" placeholder="Amount">
                    <span class="input-group-text bg-light border">BTC</span>
                </div>
                <h5 class="fw-semibold">Trade Value</h5>
                <div class="input-group mb-6">
                    <input type="text" class="form-control bg-light border" placeholder="Value">
                    <span class="input-group-text bg-light border">USD</span>
                </div>
                <button class="btn btn-danger w-100">Sell BTC</button>
            </div>

            <!-- Send Form -->
 <div class="tab-pane fade" id="sendForm">
    <p class="fw-semibold mb-8 text-primary-light">
        @php
            $walletData_x = [
                'btc' => $wallets->where('currency', 'btc')->first(),
                'eth' => $wallets->where('currency', 'eth')->first(),
                'usdt' => $wallets->where('currency', 'usdttrc20')->first(),
            ];
        @endphp

        @if ($walletData_x['btc'] || $walletData_x['eth'] || $walletData_x['usdt'])
            Choose the wallet you want to use for the transaction
        @else
            Please first create your preferred wallet
        @endif
    </p>

                       <div id="wallet_btn_block" class="flex flex-wrap gap-2">
    <?php if ($walletData['eth']['wallet']): ?>
    <button onclick="displayWalletForm('eth', '<?php echo $walletData['eth']['wallet']->address; ?>', '<?php echo $walletData['eth']['fund']; ?>')"
        class="bg-[#c59b27] hover:bg-[#b0871d] text-black font-bold py-2 px-4 rounded-xl transition-all shadow-sm">
        ETH Wallet
    </button>
    <?php endif; ?>

    <?php if ($walletData['btc']['wallet']): ?>
    <button onclick="displayWalletForm('btc', '<?php echo $walletData['btc']['wallet']->address; ?>', '<?php echo $walletData['btc']['fund']; ?>')"
        class="bg-[#c59b27] hover:bg-[#b0871d] text-black font-bold py-2 px-4 rounded-xl transition-all shadow-sm">
        BTC Wallet
    </button>
    <?php endif; ?>

    <?php if ($walletData['usdt']['wallet']): ?>
    <button onclick="displayWalletForm('usdt', '<?php echo $walletData['usdt']['wallet']->address; ?>', '<?php echo $walletData['usdt']['fund']; ?>')"
        class="bg-[#c59b27] hover:bg-[#b0871d] text-black font-bold py-2 px-4 rounded-xl transition-all shadow-sm">
        USDT Wallet
    </button>
    <?php endif; ?>
</div>
</div>


<!-- Wallet Form Block -->
<div id="wallet_form_block" style="display: none;">
    <form action="send_funds/{{ $user_id }}" method="POST">
        @csrf
        <!-- Wallet Details -->
        <div class="mb-6">
            <input type="hidden" id="btcEquivalent" name="btcEquivalent" value="">
            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Send From</label>
            <input style="background-color: transparent; color: #495057" type="text" id="fromWallet" name="fromWallet"
                class="form-control mb-6" readonly>
        </div>

        <!-- Network Selection for USDT -->
        <div id="usdt_network_list" style="display:none">
            <div class="mb-6">
                <label class="block text-sm font-semibold text-on-surface-variant mb-2">Select Network</label>
                <select id="network" class="form-select" style="background-color: transparent;">
                    <option value="trc20">TRC20</option>
                    <option value="bep20">BEP20</option>
                    <option value="eth">ETH</option>
                    <option value="erc20">ERC20</option>
                    <option value="polygon">Polygon (MATIC)</option>
                    <option value="solana">Solana</option>
                </select>
            </div>
        </div>

        <!-- Amount Field -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Amount</label>
            <input type="text" id="amount" name="amount" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required style="background-color: transparent;">
            <p id="btcConversion" class="mt-2"></p>
            <p id="amountError" class="text-error"></p>
        </div>

        <!-- Send To Address Field -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-on-surface-variant mb-2">Send To Wallet Address</label>
            <input type="text" id="toAddress" name="toAddress" class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" required style="background-color: transparent;">
        </div>

        <!-- Submit Button -->
        <button type="submit" id="send_fund_x" class="btn btn-primary w-100">Send Funds</button>
    </form>
</div>













            </div>

            <!-- Receive Form -->
<div class="tab-pane fade" id="receiveForm">

<p class="fw-semibold mb-8 text-primary-light">
    <?php if ($walletData_x['usdt'] || $walletData_x['btc']): ?>
        Choose the wallet you want to use for the deposit
    <?php else: ?>
        Please first create your preferred wallet
    <?php endif; ?>
</p>

<div id="wallet_btn_block" class="flex flex-wrap gap-2">

<?php if ($walletData_x['usdt']): ?>
    <button onclick="showWalletDetails('usdt')" data-crypto-currency="usdttrc20" class="bg-[#c59b27] hover:bg-[#b0871d] text-black font-bold py-2 px-4 rounded-xl transition-all shadow-sm">
        USDT WALLET
    </button>
<?php endif; ?>

<?php if ($walletData_x['btc']): ?>
    <button onclick="showWalletDetails('btc')" class="bg-[#c59b27] hover:bg-[#b0871d] text-black font-bold py-2 px-4 rounded-xl transition-all shadow-sm">
        BTC WALLET
    </button>
<?php endif; ?>





<?php if ($walletData_x['eth']): ?>
    <button id="receive-generate-btn" data-crypto-currency="eth" class="bg-[#c59b27] hover:bg-[#b0871d] text-black font-bold py-2 px-4 rounded-xl transition-all shadow-sm">
        ETH WALLET
    </button>
<?php endif; ?>



</div>

<div style="display: none" id="wallet_address_block">
  <div class="col-lg-12 mb-10">
      <div class="mb-10">
          <br>
          <h5 id="xx_loading" style="text-align: center">Generating
              Address <i id="loading_ani2" class="fa fa-spinner fa-spin"
                  style="display: none;"></i></h5>
          <br>
          <h6 class="mb-2 fw-bold text-lg text-center"
              id="wallet-title">Scan to receive</h6>
          <p class="fw-semibold text-primary-light mb-10 text-center"
              id="wallet-description"></p>
         <p style="text-align:center"> <img src="" id="wallet-qr" width="180px"
          class="center-img" style="margin: auto"></p>
      </div>



      <div class="module-orderform__sell-forms__item">

        <input placeholder="" style="width:100%;font-size:16px"  id="crypto_address"  type="text" />

      </div>
  </div>



  <div class="mb-24 text-center">
      <br>
      <h6 class="mb-6 fw-semibold text-xl text-error-main mb-20">Ensure
          you select the correct crypto network.</h6>
      <span class="mb-6 text-sm text-secondary-light">
          Please only use the appropriate cryptocurrency network to send
          your crypto. If you accidentally send crypto using the wrong
          network, you cannot get your crypto back.
      </span>
      <p>Note : Must reach 6 confirmations to be available in balance</p>
  </div>
</div>


  <script>
  function showWalletDetails(currency) {
      const walletData =                                                                         <?php echo json_encode($walletData_x); ?>;
      const wallet = walletData[currency];
      console.log(wallet.qr);

      if (wallet) {
          // Update QR code and address input using values fetched from the database
      const walletTitleElement = document.getElementById('wallet-title');
          
          if (currency.toUpperCase() === 'USDT') {
    walletTitleElement.innerText = `Scan to receive ${currency.toUpperCase()} - TRC20 Network`;
} else {
    walletTitleElement.innerText = `Scan to receive ${currency.toUpperCase()}`;
}

          
          if (currency.toUpperCase() === 'USDT') {
    const networkInfo = document.createElement('p'); // Create a new <p> tag
    networkInfo.innerText = 'TRC20 Network'; // Set the text content
    walletTitleElement.appendChild(networkInfo); // Append the new <p> tag below the wallet title
}
          
          document.getElementById('wallet-description').innerText =
              `You can only receive ${currency.toUpperCase()} to this address`;
          console.log();

          // Assuming wallet.qr_url is the QR image URL fetched from the database
          document.getElementById('wallet-qr').src = wallet.qr; // Update this line as necessary
          document.getElementById('crypto_address').value = wallet
              .address; // Assuming this is the wallet address fetched from the database

          // Show the wallet address block and hide the button block
          // document.getElementById('wallet_btn_block').style.display = 'none';
          document.getElementById('wallet_address_block').style.display = 'block';
      }
  }
</script>
            </div>
        </div>
    </div>
</div>

               </div>
           </div>
          <!-- End of upper flex row -->
<!---- code by aayush  -->
<div class="modal fade" id="addWallet" tabindex="-1" aria-labelledby="addWalletLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content rounded-2xl overflow-hidden shadow-2xl border border-slate-700 bg-white">
            <div id="message" style="display: none; padding: 10px; border-radius: 5px;"></div>
            <div class="modal-header bg-[#0f131a] text-white border-b border-[#c59b27]/30">
                <h5 class="modal-title font-bold text-[#dfbb58] flex items-center gap-2" id="addWalletLabel">
                    <span class="material-symbols-outlined text-[#c59b27]">add_circle</span> Add New Wallet
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-on-surface-variant mb-2">Select Wallet Currency</label>
                    <select class="form-select" id="currency" name="currency">
                       

                        <!--@if (!$walletData['eth']['wallet'])-->
                        <!--<option value="eth">Ethereum (ETH)</option>-->
                        <!--@endif-->

                        // @if (!$walletData['usdt']['wallet'])
                        // <option value="usdttrc20">USDT (TRC20)</option>
                        // @endif
                        
                         @if (!$walletData['btc']['wallet'])
                        <option value="btc">Bitcoin (BTC)</option>
                        @endif
                    </select>
                </div>

                <div class="text-center">
                    <i id="loading_ani" class="fa fa-spinner fa-spin text-primary fs-4" style="display: none;"></i>

                    <div id="generate_button_box">
                    <button class="btn btn-primary w-100 fw-bold" id="generate-btn" >
                        Generate Wallet
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>


<div>

                  <div class="flex flex-col lg:flex-row gap-6 mb-6">


     <div class="w-full lg:w-1/2 glass-panel rounded-2xl soft-shadow-hover p-4 transition-all duration-300" style="height:25rem">


               <!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>

  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
  {
  "symbols": [
    [
      "BITSTAMP:BTCUSD|1D"
    ],
    [
      "COINBASE:ETHUSD|1D"
    ],
    [
      "USDT|1D"
    ]
  ],
  "chartOnly": false,
  "width": "100%",
  "height": "100%",
  "locale": "en",
  "colorTheme": "light",
  "autosize": true,
  "showVolume": false,
  "showMA": false,
  "hideDateRanges": false,
  "hideMarketStatus": false,
  "hideSymbolLogo": false,
  "scalePosition": "right",
  "scaleMode": "Normal",
  "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
  "fontSize": "10",
  "noTimeScale": false,
  "valuesTracking": "1",
  "changeMode": "price-and-percent",
  "chartType": "area",
  "maLineColor": "#2962FF",
  "maLineWidth": 1,
  "maLength": 9,
  "headerFontSize": "medium",
  "lineWidth": 2,
  "lineType": 0,
  "dateRanges": [
    "1d|1",
    "1m|30",
    "3m|60",
    "12m|1D",
    "60m|1W",
    "all|1M"
  ]
}
  </script>
</div>
<!-- TradingView Widget END -->





     </div>

<div class="w-full lg:w-1/2 glass-panel rounded-2xl soft-shadow-hover p-4 transition-all duration-300" style="height:auto">
                     <div class="tradingview-widget-container" >
  <div class="tradingview-widget-container__widget" ></div>

  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
  {
  "autosize": true,
  "symbol": "MARKETSCOM:BITCOIN",
  "interval": "D",
  "timezone": "Etc/UTC",
  "theme": "light",
  "style": "1",
  "locale": "en",
  "allow_symbol_change": true,
  "calendar": false,
  "support_host": "https://www.tradingview.com"
}
  </script>
</div>
                  </div>




</div>
<br>

    <div class="flex flex-col gap-6 mb-6">
        <div class="w-full glass-panel rounded-2xl soft-shadow-hover p-6 overflow-x-auto transition-all duration-300">
            <div class="module-orderopen__navigation-title module-orderopen__navigation-active">
                <h4>Crypto Transaction History</h4>
            </div>

            <table class="w-full text-left border-collapse">
                <thead class="bg-surface-container-low text-on-surface-variant font-semibold">
                    <tr>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Date & Time</th>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Transaction ID</th>

                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Amount</th>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Address</th>
                        <th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap" scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trans_data as $transaction)
                        <tr>
                             <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">
                                <span class=" d-block font-weight-medium">{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i:s') }}</span>
                                <span class="text-outline text-sm">{{ \Carbon\Carbon::parse($transaction->created_at)->format('Y-m-d') }}</span>
                            </td>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">
                                <span class=" d-block font-weight-medium">{{ $transaction->tr_id }}</span>
                            </td>

                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">
                                <span class=" d-block font-weight-medium">${{ number_format($transaction->amount) }}</span>
                            </td>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface">
                                <span class=" d-block font-weight-medium">{{ $transaction->sent_from }}</span>
                            </td>
                            <td class="p-4 border-b border-surface-container-high text-sm text-on-surface" class="text-center">
                                @if ($transaction->status == 'Debit')
                                    <span class="bg-error-container text-on-error-container px-2 py-1 rounded-full text-xs font-semibold">Debit</span>
                                @elseif ($transaction->status == 'Pending')
                                    <span class="bg-[#FEF7E0] text-[#B06000] px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
                                @elseif ($transaction->status == 'Credit')
                                    <span class="bg-[#E6F4EA] text-[#137333] px-2 py-1 rounded-full text-xs font-semibold">Credit</span>
                                @elseif ($transaction->status == 'Reject')
                                    <span class="bg-error-container text-on-error-container px-2 py-1 rounded-full text-xs font-semibold">Reject</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="text-align:center"><a href="all_crypto_history">View All History</a></p>
        </div>
    </div>
</div>

    </div>
</div>

<!---- scripts by aayush  --->

 <script>
    document.getElementById('generate-btn').addEventListener('click', function() {
        console.log('Hello');

        // Show the loading spinner and hide the generate button
        const generateButton = document.getElementById("generate_button_box");
        generateButton.style.display = "none"; // Hide the button
        document.getElementById('loading_ani').style.display = 'inline-block';

        let currency = document.getElementById('currency').value;
        let user_id = '{{ $user_id }}'; // getting user ID from Blade


let apiUrl = '';
if (currency === 'btc') {
    apiUrl = "/online/btc-generate-wallet"; // Dynamic URL
} else {
    apiUrl = "/online/usdt-generate-wallet"; // Dynamic URL
}


        // Send fetch request
        fetch(apiUrl, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel's CSRF token for security
                },
                body: JSON.stringify({
                    currency: currency,
                    user_id: user_id
                })
            })
            .then(response => response.json())
            .then(data => {
                // Hide the loading spinner before showing the alert
                document.getElementById('loading_ani').style.display = 'none';

                const messageContainer = document.getElementById("message");
                messageContainer.style.display = "block"; // Show message

                if (data.success) {
                    // Success message styling
                    messageContainer.style.backgroundColor = "#d4edda"; // Light green background
                    messageContainer.style.color = "#155724"; // Dark green text
                    messageContainer.innerHTML = "Wallet generated successfully! close dialog box to continue.";
                } else {
                    // Error message styling
                    messageContainer.style.backgroundColor = "#f8d7da"; // Light red background
                    messageContainer.style.color = "#721c24"; // Dark red text
                    messageContainer.innerHTML = "Error generating wallet!";
                }
            })
            .catch(error => {
                // Hide the loading spinner in case of an error as well
                document.getElementById('loading_ani').style.display = 'none';
                alert("An error occurred while generating the wallet!");
                console.error('Error:', error);
            });
    });
</script>





<script>
        document.querySelectorAll('#receive-generate-btn').forEach(button => {
            button.addEventListener('click', function() {

                // document.getElementById('wallet_btn_block').style.display = 'none';
                document.getElementById('wallet_address_block').style.display = 'block';
                document.getElementById('xx_loading').style.display = 'block';
                document.getElementById('loading_ani2').style.display = 'inline-block';
                console.log('hi');


                let currency = this.getAttribute('data-crypto-currency');
                console.log(currency);

                let user_id = '{{ $user_id }}';

                let apiUrl = "https://ibank.firstallianzgroup.com/online/generate-wallet";

                fetch(apiUrl, {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel's CSRF token for security
                        },
                        body: JSON.stringify({
                            currency: currency,
                            user_id: user_id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {

                            let currency = data.data.currency; // Extract currency from response
                            let address = data.data.address; // Extract address from response
                            console.log(address);

                            let qr = data.data.qr;

                            // Update QR code and address input using values fetched from the database
                             const walletTitleElement = document.getElementById('wallet-title');
          
          if (currency.toUpperCase() === 'USDT') {
    walletTitleElement.innerText = `Scan to receive ${currency.toUpperCase()} - TRC20 Network`;
} else {
    walletTitleElement.innerText = `Scan to receive ${currency.toUpperCase()}`;
}

                            document.getElementById('wallet-description').innerText =
                                `You can only receive ${currency.toUpperCase()} to this address`;
                            console.log();

                            // Assuming wallet.qr_url is the QR image URL fetched from the database
                            document.getElementById('wallet-qr').src =
                            qr; // Update this line as necessary
                            document.getElementById('crypto_address').value =
                            address; // Assuming this is the wallet address fetched from the database

                            // Show the wallet address block and hide the button block
                            document.getElementById('loading_ani2').style.display = 'none';
                            document.getElementById('xx_loading').style.display = 'none';


                        } else {
                            messageContainer.style.backgroundColor = "#f8d7da"; // Light red background
                            messageContainer.style.color = "#721c24"; // Dark red text
                            messageContainer.innerHTML = "Error generating wallet!";
                        }
                    })
                    .catch(error => {
                        alert("An error occurred while generating the wallet!");
                        console.error('Error:', error);
                    });
            });
        });
    </script>



<script>
    // Function to fetch the live BTC price from the PHP proxy
    function getBtcToUsdPrice() {
        return fetch('https://ibank.firstallianzgroup.com/proxy.php') // Update this with the correct path to your proxy
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error fetching BTC price:', data.error);
                    return 50000; // Default price in case of error
                }
                return data.price; // Return the BTC price in USD from Blockonomics
            })
            .catch(error => {
                console.error('Error fetching BTC price:', error);
                return 50000; // Default price in case of error
            });
    }

    // Function to display the wallet form and handle user input
    function displayWalletForm(currency) {
        // Retrieve wallet data from PHP variables passed to JavaScript
        const walletData =                           <?php echo json_encode($walletData); ?>;
        const wallet = walletData[currency];

        // Ensure that wallet balance is properly fetched from PHP
        let walletBalance = 0; // Default to 0 in case of errors
        if (currency === 'btc') {
            walletBalance =                            <?php echo json_encode($btc_fund); ?> || 0; // Default to 0 if PHP value is null
        } else if (currency === 'usdt') {
            walletBalance =                            <?php echo json_encode($usdt_fund); ?> || 0;
        } else if (currency === 'eth') {
            walletBalance =                            <?php echo json_encode($eth_fund); ?> || 0;
        }

        // Log wallet balance for debugging
        console.log(`Wallet Balance (${currency}):`, walletBalance);
        console.log(currency);

        const btcConversionElement = document.getElementById('btcConversion');
        const usdtNetworkList = document.getElementById('usdt_network_list'); // The USDT network list

        // Handle network selection and conversion visibility
        if (currency === 'usdt') {
            console.log('working2');

            // Hide the BTC conversion span when using USDT
            btcConversionElement.style.display = 'none';
            btcConversionElement.textContent = '';  // Clear any previous BTC conversion

            // Show the USDT network list
            usdtNetworkList.style.display = 'block';
        } else {
            // Hide the USDT network list if currency is not USDT
            usdtNetworkList.style.display = 'none';
        }

        // If the wallet data exists
        if (wallet) {
            // Update form fields with wallet address
            document.getElementById('fromWallet').value = wallet.wallet.address;

            // Show the wallet form
            document.getElementById('wallet_form_block').style.display = 'block';

            // Add event listener for amount input field
            document.getElementById('amount').addEventListener('input', function () {
                const amountInput = parseFloat(this.value); // Get the user input as USD
                const errorSpan = document.getElementById('amountError');
                const sendfund_x = document.getElementById('send_fund_x');

                // Reset all errors and hide the BTC conversion when switching to USDT
                if (currency === 'usdt') {
                    btcConversionElement.style.display = 'none'; // Hide the BTC conversion span
                    btcConversionElement.textContent = ''; // Clear the content
                }

                // If the currency is BTC, convert USD to BTC
                if (currency === 'btc') {
                    console.log('working1');
                    // Fetch live BTC price and calculate the amount in BTC
                    getBtcToUsdPrice().then(btcPriceInUsd => {
                        // Convert USD to BTC
                        const usdToBtc = amountInput / btcPriceInUsd;

                        // Limit the result to 6 decimal places for precision
                        const btcAmount = usdToBtc.toFixed(6);

                        console.log(`Converted USD to BTC: ${btcAmount}`);
                        console.log(`Wallet Balance (BTC): ${walletBalance}`);

                        // Display the BTC conversion in the input field or next to it
                        btcConversionElement.style.display = 'inline'; // Show the BTC conversion span
                        btcConversionElement.textContent = `(${btcAmount} BTC)`; // Show the BTC conversion next to the amount

                        // Check if the converted BTC amount exceeds the wallet balance
                        if (parseFloat(btcAmount) > walletBalance) {
                            // Show error if the entered amount exceeds wallet balance
                            errorSpan.innerText = "Error: The entered amount exceeds your wallet balance.";
                            this.classList.add('is-invalid');
                            sendfund_x.style.display = 'none';
                        } else {
                            // Clear error and show the send funds button
                            errorSpan.innerText = "";
                            this.classList.remove('is-invalid');
                            sendfund_x.style.display = 'block';
                        }

                        // Save the BTC equivalent value (in USD) for submission
                        document.getElementById('btcEquivalent').value = btcAmount; // Hidden input to save the BTC value
                    });
                }
                else if (currency === 'usdt') {
                    // For USDT: Just check the balance and show error if needed
                    console.log('working2');
                    if (amountInput > walletBalance) {
                        // Show error message if the entered amount is greater than balance
                        errorSpan.innerText = "Error: The entered amount exceeds your wallet balance.";
                        this.classList.add('is-invalid');
                        sendfund_x.style.display = 'none';
                    } else {
                        // Clear error message if amount is valid
                        errorSpan.innerText = "";
                        this.classList.remove('is-invalid');
                        sendfund_x.style.display = 'block';
                    }
                }
            });
        }
    }
</script>


<script>
  // Function to update prices
  function updatePrices() {
      console.log('Testing updatePrices function.');

      const apiUrl = "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,tether&vs_currencies=usd"; // Use your server URL for the PHP proxy
      fetch(apiUrl)
          .then(response => response.json())
          .then(data => {
              console.log('Fetched rates:', data);

              let totalBalance = 0; // Initialize total balance

              <?php foreach ($displayWallets as $wallet): ?>
                  (function() {
                      const currencyType = "{{ strtolower($wallet->currency) }}";
                      const amountEl = document.getElementById('amount-{{ $wallet->id }}');
                      const amount = amountEl ? parseFloat(amountEl.textContent) || 0 : 0;
                      const tradeValueElement = document.getElementById('trade-value-{{ $wallet->id }}');
                           
                      if (currencyType === 'btc' && data.bitcoin && data.bitcoin.usd) {
                          const tradeValue = amount * data.bitcoin.usd;
                          if (tradeValueElement) {
                              tradeValueElement.innerHTML = `<span class="${tradeValue > 0 ? 'text-secondary' : 'text-error'}">$${tradeValue.toFixed(2)}</span>`;
                          }
                          totalBalance += tradeValue;
                      } else if (currencyType === 'usdttrc20') {
                          const tradeValue = amount;
                          if (tradeValueElement) {
                              tradeValueElement.innerHTML = `<span class="${tradeValue > 0 ? 'text-secondary' : 'text-error'}">$${tradeValue.toFixed(2)}</span>`;
                          }
                          totalBalance += tradeValue;
                      }
                  })();
              <?php endforeach; ?>

              // Update the total live wallet balance with the aggregated value
              const totalBalanceElement = document.getElementById('total_live_wallet_balance');
              if (totalBalanceElement) {
                  totalBalanceElement.innerHTML = `<span class="${totalBalance > 0 ? 'text-secondary' : 'text-error'}">$${totalBalance.toFixed(2)}</span>`;
              }
          })
          .catch(error => console.error('Error fetching data:', error));
  }

  // Run updatePrices once on page load
  window.onload = function() {
      updatePrices();

      // Run the update every 10 seconds after that
      setInterval(updatePrices, 10000); // Update every 10 seconds
  };
</script>


<script type="text/javascript">
function changeRandomimage() {
    var imageArray = ["<?php echo asset('images/dashboard1.png') ?>","<?php echo asset('images/dashboard2.png') ?>"];
    var randomImage = Math.floor(Math.random() * imageArray.length);
    $('#imgDash').attr('src',imageArray[randomImage]);
}
changeRandomimage();
</script>
<!-- footer -->


<!-- Add this inside your <head> for Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    function openTab() {
    // Select the tab element
    var receiveTab = new bootstrap.Tab(document.getElementById('receive-tab'));

     document.getElementById('wallet_form_block').style.display = 'none';
    // Show the 'Receive' tab
    receiveTab.show();
}

</script>

@include('footer')
<!-- // footer -->
