<?php
/*********************************
 * CONFIG
 *********************************/
$CF_API_TOKEN  = 'kclaO7zYnTEgTfLiGi8-r4eJ47VrGD0Hd1-I8dLV';

$CF_ZONE_ID     = 'bc3015baa6aecf90748650375766917c';
$CF_RULESET_ID = '82d3da100bcd420a847a2c18fc77314f';
$CF_RULE_ID    = 'd7801dff3ed944a591d94e93132027a0';

$message = '';
$updateBlocked = false;

/*********************************
 * COUNTRY LIST
 *********************************/
$countries = [
    'IN'=>'India','AE'=>'United Arab Emirates','US'=>'United States','GB'=>'United Kingdom',
    'CA'=>'Canada','AU'=>'Australia','DE'=>'Germany','FR'=>'France','IT'=>'Italy',
    'ES'=>'Spain','NL'=>'Netherlands','SG'=>'Singapore','JP'=>'Japan','CN'=>'China',
    'BR'=>'Brazil','ZA'=>'South Africa','RU'=>'Russia','TR'=>'Turkey','SA'=>'Saudi Arabia',
    'ID'=>'Indonesia','TH'=>'Thailand','MY'=>'Malaysia','PH'=>'Philippines',
    'VN'=>'Vietnam','BD'=>'Bangladesh','PK'=>'Pakistan','LK'=>'Sri Lanka',
    'NP'=>'Nepal','MX'=>'Mexico','AR'=>'Argentina','CL'=>'Chile','CO'=>'Colombia'
];

/*********************************
 * FETCH RULESET (CORRECT WAY)
 *********************************/
$currentAllowed = [];
$expression = null;

$rulesetUrl = "https://api.cloudflare.com/client/v4/zones/$CF_ZONE_ID/rulesets/$CF_RULESET_ID";

$ch = curl_init($rulesetUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $CF_API_TOKEN",
        "Content-Type: application/json"
    ]
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

/**
 * Find rule inside ruleset
 */
if (!empty($data['success']) && !empty($data['result']['rules'])) {
    foreach ($data['result']['rules'] as $rule) {
        if (!empty($rule['id']) && $rule['id'] === $CF_RULE_ID) {
            $expression = $rule['expression'] ?? null;
            break;
        }
    }
}

/**
 * Extract ISO country codes safely
 */
if ($expression) {
    preg_match_all('/"([A-Z]{2})"/', $expression, $matches);
    $currentAllowed = $matches[1] ?? [];
}

/**
 * Safety: block updates only if rule truly unreadable
 */
if (empty($currentAllowed)) {
    $updateBlocked = true;
    $message = "⚠ Unable to detect current Cloudflare rule. Update disabled for safety.";
}

/*********************************
 * HANDLE UPDATE (PATCH WORKS)
 *********************************/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$updateBlocked) {

    $allowed = $_POST['countries'] ?? [];

    // HARD SAFETY: never allow zero
    if (count($allowed) === 0) {
        $message = "❌ At least one country must remain allowed.";
    } else {

        $allowed = array_map('strtoupper', $allowed);
        $expression = '(not ip.geoip.country in {"' . implode('" "', $allowed) . '"})';

        $patchUrl = "https://api.cloudflare.com/client/v4/zones/$CF_ZONE_ID/rulesets/$CF_RULESET_ID/rules/$CF_RULE_ID";

        $payload = [
            "action"     => "block",
            "enabled"    => true,
            "expression" => $expression
        ];

        $ch = curl_init($patchUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "PATCH",
            CURLOPT_HTTPHEADER     => [
                "Authorization: Bearer $CF_API_TOKEN",
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload)
        ]);

        $updateResponse = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($updateResponse, true);

        if (!empty($result['success'])) {
            $message = "✅ Rule updated successfully.";
            $currentAllowed = $allowed;
        } else {
            $message = "❌ Update failed.<pre>" . htmlspecialchars($updateResponse) . "</pre>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Country Access Control (Admin)</title>
    <style>
        body{font-family:Arial;background:#f4f4f4;padding:40px}
        .box{background:#fff;padding:20px;max-width:900px;border-radius:8px}
        .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
        label{display:flex;gap:6px;align-items:center}
        button{margin-top:15px;padding:10px 20px}
        .msg{margin:15px 0;font-weight:bold}
        .warn{color:#c00}
        .ok{color:green}
    </style>
</head>
<body>

<div class="box">
    <h2>🌍 Country Access Control (Admin)</h2>

    <?php if (!empty($currentAllowed)): ?>
        <p class="ok">
            ✅ Currently allowed:
            <b><?= implode(', ', $currentAllowed) ?></b>
        </p>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="msg <?= $updateBlocked ? 'warn' : '' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="grid">
            <?php foreach ($countries as $code=>$name): ?>
                <label>
                    <input type="checkbox"
                           name="countries[]"
                           value="<?= $code ?>"
                           <?= in_array($code, $currentAllowed) ? 'checked' : '' ?>
                           <?= $updateBlocked ? 'disabled' : '' ?>>
                    <?= $name ?> (<?= $code ?>)
                </label>
            <?php endforeach; ?>
        </div>

        <button type="submit" <?= $updateBlocked ? 'disabled' : '' ?>>
            Update Rule
        </button>
    </form>

    <p style="font-size:12px;color:#666;margin-top:15px">
        ⚠ Safety enabled: at least one country must always remain allowed.
    </p>
</div>

</body>
</html>
