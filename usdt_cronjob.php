<?php
// ========================================
// USDT TRC20 Wallet Checker (Cron Job)
// ========================================

ini_set('display_errors', 1);
error_reporting(E_ALL);

// ---------- SETTINGS ----------
$logFile = __DIR__ . '/usdt_cron.log';
ini_set('log_errors', 1);
ini_set('error_log', $logFile);

function logMsg($msg) {
    $time = date('Y-m-d H:i:s');
    echo "[$time] $msg<br>\n";
    error_log("[$time] $msg");
}

// ---------- DATABASE CONNECTION ----------
// !!! REPLACE WITH YOUR ACTUAL DB CREDENTIALS !!!
$conn = new mysqli('localhost', 'bank_db1', 'bank_db2', 'bank_db-35303936ff43');

if ($conn->connect_error) {
    logMsg("DB Connection failed: " . $conn->connect_error);
    exit;
}
logMsg("DB connected successfully.");

// ---------- FETCH WALLETS ----------
$sql = "SELECT * FROM wallets WHERE currency = 'USDTTRC20' ORDER BY id DESC";
$result = $conn->query($sql);
if (!$result || $result->num_rows === 0) {
    logMsg("No wallets found in DB.");
    exit;
}

logMsg("Cron job started.");

while ($row = $result->fetch_assoc()) {
    $user_id = $row['user_id'];
    $wallet  = trim($row['address']);
    logMsg("Processing wallet: $wallet");

    $fingerprint = null;
    $page = 1;

    do {
        $url = "https://api.trongrid.io/v1/accounts/$wallet/transactions/trc20?limit=50";
        if ($fingerprint) {
            $url .= "&fingerprint=" . urlencode($fingerprint);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            logMsg("API error for wallet: $wallet");
            break;
        }

        $data = json_decode($response, true);
        if (empty($data['data'])) {
            logMsg("No transactions found for wallet: $wallet on page $page");
            break;
        }

        foreach ($data['data'] as $transaction) {
            // Only USDT
            if (
    empty($transaction['token_info']['symbol']) ||
    strtoupper($transaction['token_info']['symbol']) !== 'USDT' ||
    strcasecmp($transaction['from'], $wallet) === 0 // Skip withdrawals
) {
    continue;
}

            $transaction_id = $conn->real_escape_string($transaction['transaction_id']);

            // Check duplicate
            $exists = $conn->query("SELECT id FROM transactions WHERE tr_id = '$transaction_id' LIMIT 1");
            if ($exists && $exists->num_rows > 0) {
                logMsg("Transaction already exists: $transaction_id");
                continue;
            }

            // Amount
            $value = $transaction['value'];
            $decimals = $transaction['token_info']['decimals'] ?? 6;
            $adjustedValue = $value / pow(10, $decimals);

            // User info
            $userRes = $conn->query("SELECT cust_mail, cust_name FROM ba_account_holders WHERE user_id = '$user_id' LIMIT 1");
            if (!$userRes || $userRes->num_rows === 0) {
                logMsg("User not found for wallet: $wallet");
                continue;
            }
            $user = $userRes->fetch_object();

            // Email
            $subject = 'Deposit Confirmation: Amount Successfully Credited';
            $body = "<p>Dear {$user->cust_name},</p><p>We have credited $adjustedValue USDT to your account.</p>";
            $headers = "MIME-Version: 1.0\r\nContent-type:text/html;charset=UTF-8\r\nFrom: info@firstallianzgroup.com\r\n";

            // if (mail($user->cust_mail, $subject, $body, $headers)) {
            //     logMsg("Email sent to {$user->cust_mail} for TX: $transaction_id");
            // } else {
            //     logMsg("Email failed for TX: $transaction_id");
            // }

            // Insert TX
            $insertSQL = "INSERT INTO transactions (user_id, subject, status, amount, currency, tr_id, sent_from, sent_to, created_at, updated_at) 
                          VALUES ('$user_id', 'Funds Deposit', 'Credit', '$adjustedValue', 'USDTTRC20', '$transaction_id', '{$transaction['to']}', '', NOW(), NOW())";
            if ($conn->query($insertSQL)) {
                logMsg("Inserted TX: $transaction_id");
            } else {
                logMsg("Insert error: " . $conn->error);
            }

            // Update balance
            if ($conn->query("UPDATE ba_account_holders SET usdt_fund = usdt_fund + $adjustedValue WHERE user_id = '$user_id'")) {
                logMsg("Updated balance for user_id $user_id (+$adjustedValue USDT)");
            } else {
                logMsg("Balance update error: " . $conn->error);
            }

            // Pause after each transaction
            sleep(1);
        }

        $fingerprint = $data['meta']['fingerprint'] ?? null;
        $page++;
        // Pause between API pages
        usleep(300000);

    } while ($fingerprint);

    // Pause after processing each wallet
    sleep(1);
}

// ---------- END ----------
logMsg("Cron job finished.");
$conn->close();
?>