<?php

$apiKey = 't-68701ca29274db8a4e30348f-ce52d402affd4437a05438ae';
$address = 'TP5ZCS6NtaUXywUMpT2Pi84ZF71bexFGFv';

function fetchFromTatum($url, $apiKey) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "x-api-key: $apiKey"
        ]
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// 1. Get TRX transactions
$trxTxs = fetchFromTatum("https://api.tatum.io/v3/tron/transaction/account/$address?limit=10", $apiKey);

// 2. Get USDT (TRC20) transactions
$usdtTxs = fetchFromTatum("https://api.tatum.io/v3/tron/transaction/account/$address/trc20", $apiKey);

// 3. Combine & label
$allTxs = [];

if (isset($trxTxs['data'])) {
    foreach ($trxTxs['data'] as $tx) {
        $allTxs[] = [
            'type' => 'TRX',
            'txID' => $tx['txID'] ?? '',
            'from' => $tx['from'] ?? '',
            'to' => $tx['to'] ?? '',
            'amount' => $tx['amount'] ?? '',
        ];
    }
}

if (isset($usdtTxs['transactions'])) {
    foreach ($usdtTxs['transactions'] as $tx) {
        $allTxs[] = [
            'type' => $tx['tokenInfo']['symbol'] ?? 'TRC20',
            'txID' => $tx['txID'] ?? '',
            'from' => $tx['from'] ?? '',
            'to' => $tx['to'] ?? '',
            'amount' => isset($tx['value'], $tx['tokenInfo']['decimals']) ? 
                $tx['value'] / pow(10, $tx['tokenInfo']['decimals']) : '',
        ];
    }
}

// Pretty print
echo "<pre>" . json_encode($allTxs, JSON_PRETTY_PRINT) . "</pre>";
