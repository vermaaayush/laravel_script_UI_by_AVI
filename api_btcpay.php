<?php
// Log file path
$logFile = 'logfile.log';

// Test logging to ensure it's working
file_put_contents($logFile, "Test log entry: IPN script initiated.\n", FILE_APPEND);

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the raw POST data (IPN request)
    $ipnData = file_get_contents("php://input");


    // Decode JSON data
    $data = json_decode($ipnData, true); // Assuming JSON format

    // Check if the data is valid and not empty
    if (!empty($data)) {
        // Extract relevant fields
        $orderId = $data['order_id'] ?? 'N/A';
        $payAddress = $data['pay_address'] ?? 'N/A';
        $payAmount = $data['pay_amount'] ?? 'N/A';
        $priceAmount = $data['price_amount'] ?? 'N/A';
        $payCurrency = $data['pay_currency'] ?? 'N/A';
        $paymentId = $data['payment_id'] ?? 'N/A';
        $paymentStatus = $data['payment_status'] ?? 'N/A';
         
          file_put_contents($logFile, "Decoded IPN Data: " . print_r($data, true) . "\n", FILE_APPEND);


         $extractedData = [
        'orderId' => $orderId,
        'payAddress' => $payAddress,
        'payAmount' => $payAmount,
        'priceAmount' => $priceAmount,
        'payCurrency' => $payCurrency,
        'paymentId' => $paymentId,
        'paymentStatus' => $paymentStatus,
       
    ];
    
    
    $queryString = http_build_query($extractedData);
    $baseUrl = 'https://ibank.firstallianzgroup.com/ipn';
    $redirectUrl = $baseUrl . '?' . $queryString;
    
    header('Location: ' . $redirectUrl);
        
    } else {
        echo "No valid IPN data received.";
        file_put_contents($logFile, "No valid IPN data received.\n", FILE_APPEND);
    }
} else {
    echo "Invalid request method. Only POST is allowed.";
    file_put_contents($logFile, "Invalid request method. Only POST is allowed.\n", FILE_APPEND);
}

// Respond with 200 OK status
http_response_code(200);
?>
