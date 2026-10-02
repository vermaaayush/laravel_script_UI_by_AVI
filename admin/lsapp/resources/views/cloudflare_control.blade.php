<?php
/*********************************
 * CONFIGURATION
 *********************************/
// Replace with your actual credentials
$CF_API_TOKEN  = 'kclaO7zYnTEgTfLiGi8-r4eJ47VrGD0Hd1-I8dLV';
$CF_ZONE_ID    = 'bc3015baa6aecf90748650375766917c';
$CF_RULESET_ID = '82d3da100bcd420a847a2c18fc77314f';
$CF_RULE_ID    = 'd7801dff3ed944a591d94e93132027a0';

// Full Country List (ISO 3166-1 alpha-2)
$countries = [
    'AF' => 'Afghanistan', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra',
    'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua and Barbuda', 'AR' => 'Argentina',
    'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan',
    'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus',
    'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan',
    'BO' => 'Bolivia', 'BQ' => 'Bonaire, Sint Eustatius and Saba', 'BA' => 'Bosnia and Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island',
    'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso',
    'BI' => 'Burundi', 'CV' => 'Cabo Verde', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada',
    'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China',
    'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CD' => 'Congo (Dem. Rep.)',
    'CG' => 'Congo', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'HR' => 'Croatia', 'CU' => 'Cuba',
    'CW' => 'Curaçao', 'CY' => 'Cyprus', 'CZ' => 'Czechia', 'CI' => 'Côte d\'Ivoire', 'DK' => 'Denmark',
    'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt',
    'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'SZ' => 'Eswatini',
    'ET' => 'Ethiopia', 'FK' => 'Falkland Islands', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland',
    'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon',
    'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar',
    'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam',
    'GT' => 'Guatemala', 'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana',
    'HT' => 'Haiti', 'HM' => 'Heard Island and McDonald Islands', 'VA' => 'Holy See', 'HN' => 'Honduras', 'HK' => 'Hong Kong',
    'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran',
    'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle of Man', 'IL' => 'Israel', 'IT' => 'Italy',
    'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan',
    'KE' => 'Kenya', 'KI' => 'Kiribati', 'KP' => 'North Korea', 'KR' => 'South Korea', 'KW' => 'Kuwait',
    'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho',
    'LR' => 'Liberia', 'LY' => 'Libya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg',
    'MO' => 'Macao', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives',
    'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania',
    'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia', 'MD' => 'Moldova',
    'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco',
    'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal',
    'NL' => 'Netherlands', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger',
    'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MK' => 'North Macedonia', 'MP' => 'Northern Mariana Islands',
    'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestine, State of',
    'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines',
    'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar',
    'RO' => 'Romania', 'RU' => 'Russia', 'RW' => 'Rwanda', 'RE' => 'Réunion', 'BL' => 'Saint Barthélemy',
    'SH' => 'Saint Helena, Ascension and Tristan da Cunha', 'KN' => 'Saint Kitts and Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin (French part)', 'PM' => 'Saint Pierre and Miquelon',
    'VC' => 'Saint Vincent and the Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome and Principe', 'SA' => 'Saudi Arabia',
    'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore',
    'SX' => 'Sint Maarten (Dutch part)', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia',
    'ZA' => 'South Africa', 'GS' => 'South Georgia and the South Sandwich Islands', 'SS' => 'South Sudan', 'ES' => 'Spain', 'LK' => 'Sri Lanka',
    'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard and Jan Mayen', 'SE' => 'Sweden', 'CH' => 'Switzerland',
    'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand',
    'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad and Tobago',
    'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks and Caicos Islands', 'TV' => 'Tuvalu',
    'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States',
    'UM' => 'United States Minor Outlying Islands', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela',
    'VN' => 'Vietnam', 'VG' => 'Virgin Islands (British)', 'VI' => 'Virgin Islands (U.S.)', 'WF' => 'Wallis and Futuna', 'EH' => 'Western Sahara',
    'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe'
];

$message = '';
$messageType = '';

/*********************************
 * HELPER FUNCTIONS
 *********************************/

function callCloudflare($url, $method = 'GET', $data = null) {
    global $CF_API_TOKEN;
    $ch = curl_init($url);
    $headers = [
        "Authorization: Bearer $CF_API_TOKEN",
        "Content-Type: application/json"
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['code' => $httpCode, 'data' => json_decode($response, true)];
}

/*********************************
 * LOGIC: FETCH EXISTING RULE
 *********************************/
$currentCountries = [];
$currentIPs = [];
$currentRanges = [];

$rulesetUrl = "https://api.cloudflare.com/client/v4/zones/$CF_ZONE_ID/rulesets/$CF_RULESET_ID";
$fetchResult = callCloudflare($rulesetUrl);

$expression = null;

if (!empty($fetchResult['data']['success']) && !empty($fetchResult['data']['result']['rules'])) {
    foreach ($fetchResult['data']['result']['rules'] as $rule) {
        if (!empty($rule['id']) && $rule['id'] === $CF_RULE_ID) {
            $expression = $rule['expression'] ?? null;
            break;
        }
    }
}

// PARSE EXPRESSION
if ($expression) {
    // 1. Extract Countries: (not ip.geoip.country in {"US" "CA"})
    if (preg_match('/not ip\.geoip\.country in \{([^\}]+)\}/', $expression, $matches)) {
        preg_match_all('/"([A-Z]{2})"/', $matches[1], $countryMatches);
        $currentCountries = $countryMatches[1] ?? [];
    }

    // 2. Extract IPs and Ranges: (ip.src in {1.2.3.4 192.168.0.0/24})
    if (preg_match('/ip\.src in \{([^\}]+)\}/', $expression, $matches)) {
        $rawIPs = explode(' ', str_replace('"', '', $matches[1])); // Clean quotes if any
        foreach ($rawIPs as $ipToken) {
            $ipToken = trim($ipToken);
            if (empty($ipToken)) continue;
            
            if (strpos($ipToken, '/') !== false) {
                $currentRanges[] = $ipToken;
            } else {
                $currentIPs[] = $ipToken;
            }
        }
    }
} else {
    $message = "⚠ Warning: Could not find or parse the specified Cloudflare Rule.";
    $messageType = 'error';
}

/*********************************
 * LOGIC: HANDLE FORM SUBMIT
 *********************************/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Get Countries
    $newCountries = $_POST['countries'] ?? [];
    
    // 2. Get IPs (Handle Array from Table Inputs OR String Fallback)
    $rawIPs = $_POST['blocked_ips'] ?? [];
    if (!is_array($rawIPs)) $rawIPs = explode("\n", $rawIPs);
    $newIPs = array_unique(array_filter(array_map('trim', $rawIPs)));

    // 3. Get Ranges
    $rawRanges = $_POST['blocked_ranges'] ?? [];
    if (!is_array($rawRanges)) $rawRanges = explode("\n", $rawRanges);
    $newRanges = array_unique(array_filter(array_map('trim', $rawRanges)));
    
    // Safety
    // Build Expression
    $parts = [];

    // Part A: Block IPs/Ranges
    $allBlockIPs = array_merge($newIPs, $newRanges);
    if (!empty($allBlockIPs)) {
        $ipListStr = implode(' ', $allBlockIPs); 
        $parts[] = "(ip.src in {{$ipListStr}})";
    }

    // Part B: Limit Countries
    if (!empty($newCountries)) {
        $cList = implode('" "', array_map('strtoupper', $newCountries));
        $parts[] = "(not ip.geoip.country in {\"{$cList}\"})";
    } else {
        // Whitelist is empty -> Block Everyone (except Admin Bypass)
        // We use "XX" (a reserved/private use ISO code) to ensure 'not in' matches all real countries
        $parts[] = "(not ip.geoip.country in {\"XX\"})";
    }

    // Combine Block Logic
    $blockExpression = count($parts) > 0 ? implode(' or ', $parts) : "false";

    // ADD ADMIN BYPASS
    // Ensure admin folder is excluded from blocking rules
    $finalExpression = "({$blockExpression}) and (not http.request.uri.path contains \"/admin/\")";

    // Update Cloudflare
    $patchUrl = "https://api.cloudflare.com/client/v4/zones/$CF_ZONE_ID/rulesets/$CF_RULESET_ID/rules/$CF_RULE_ID";
    $payload = [
        "action" => "block",
        "enabled" => true,
        "expression" => $finalExpression,
        "description" => "Admin Panel Managed Rule (With Admin Bypass)"
    ];

    $updateResult = callCloudflare($patchUrl, 'PATCH', $payload);

    if (!empty($updateResult['data']['success'])) {
        $message = "✅ Cloudflare Updated Successfully! (Admin Access Protected)";
        $messageType = 'success';
        $currentCountries = $newCountries;
        $currentIPs = $newIPs;
        $currentRanges = $newRanges;
    } else {
        $message = "❌ Update Failed: " . pretty_print_error($updateResult);
        $messageType = 'error';
    }
}

function pretty_print_error($res) {
    if (isset($res['data']['errors'][0]['message'])) {
        return $res['data']['errors'][0]['message'];
    }
    return 'Unknown API Error';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cloudflare Pro Admin</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #eef2f5; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h1 { margin-top: 0; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px; }
        
        .alert { padding: 15px; border-radius: 6px; margin-bottom: 20px; font-weight: 500; }
        .alert.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .grid-section { display: grid; grid-template-columns: 2fr 1.5fr; gap: 30px; }
        
        .panel { background: #fafafa; border: 1px solid #eee; padding: 20px; border-radius: 8px; }
        .panel h3 { margin-top: 0; color: #2c3e50; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 15px; }

        /* Country Grid */
        .country-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 8px; max-height: 500px; overflow-y: auto; padding-right: 5px; }
        .country-item { font-size: 13px; display: flex; align-items: center; padding: 4px; border-radius: 4px; transition: background 0.1s; cursor: pointer; }
        .country-item:hover { background: #e9ecef; }
        .country-item input { margin-right: 8px; }
        .controls { margin-bottom: 10px; display: flex; gap: 10px; }

        /* IP Tables */
        .ip-table { width: 100%; border-collapse: collapse; margin-top: 10px; background: white; }
        .ip-table th, .ip-table td { padding: 8px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
        .ip-table th { background: #f1f1f1; color: #555; }
        .ip-row:hover { background: #f9f9f9; }
        
        .btn { border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; }
        .btn-small { background: #e2e6ea; color: #495057; }
        .btn-small:hover { background: #dae0e5; }
        
        .btn-danger { background: #ffdede; color: #c0392b; padding: 4px 8px; font-size: 11px; }
        .btn-danger:hover { background: #ffcccc; }

        .btn-add { background: #2ecc71; color: white; display: inline-flex; align-items: center; gap: 5px; }
        .btn-add:hover { background: #27ae60; }
        
        .btn-submit { background: #3498db; color: white; padding: 15px 30px; font-size: 18px; width: 100%; margin-top: 20px; transition: background 0.2s; }
        .btn-submit:hover { background: #2980b9; }

        .add-box { display: flex; gap: 5px; margin-bottom: 15px; }
        .add-input { padding: 8px; border: 1px solid #ddd; border-radius: 4px; flex-grow: 1; }

        .flag-icon { margin-right: 5px; font-size: 1.2em; }
        .loading-text { font-style: italic; color: #999; font-size: 0.9em; }
    </style>
    <script>
        function toggleAll(checked) {
            document.querySelectorAll('input[name="countries[]"]').forEach(cb => cb.checked = checked);
        }

        // ---- IP TABLE LOGIC ----
        async function fetchIpInfo(ip, elementId) {
            try {
                // Using ip-api.com (free, no key, limited rate)
                // Note: If you are on HTTPS, this HTTP req might be blocked. 
                // Alternative: https://ipapi.co/{ip}/json/ or internal PHP proxy
                const response = await fetch(`http://ip-api.com/json/${ip}?fields=status,country,countryCode`);
                const data = await response.json();
                const el = document.getElementById(elementId);
                if (data.status === 'success') {
                    el.innerHTML = `<span title="${data.countryCode}">${data.country}</span>`;
                } else {
                    el.innerHTML = '<span style="color:#999">Unknown</span>';
                }
            } catch (e) {
                document.getElementById(elementId).innerHTML = '<span style="color:#999">-</span>';
            }
        }

        function createRow(type, value) {
            const tableId = type === 'ip' ? 'ipTableBody' : 'rangeTableBody';
            const inputName = type === 'ip' ? 'blocked_ips[]' : 'blocked_ranges[]';
            const tbody = document.getElementById(tableId);
            const rowId = 'row_' + Math.random().toString(36).substr(2, 9);
            const infoId = 'info_' + rowId;

            const tr = document.createElement('tr');
            tr.className = 'ip-row';
            tr.innerHTML = `
                <td>
                    ${value}
                    <input type="hidden" name="${inputName}" value="${value}">
                </td>
                <td id="${infoId}"><span class="loading-text">Loading...</span></td>
                <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">Remove</button></td>
            `;
            tbody.appendChild(tr);

            // Fetch info only for standard IPs, ranges are harder to lookup
            if (type === 'ip') {
                fetchIpInfo(value, infoId);
            } else {
                document.getElementById(infoId).innerHTML = '<span style="color:#888">Range</span>';
            }
        }

        function handleAdd(type) {
            const inputId = type === 'ip' ? 'newIpInput' : 'newRangeInput';
            const input = document.getElementById(inputId);
            const val = input.value.trim();
            if (val) {
                createRow(type, val);
                input.value = '';
            }
        }
    </script>
</head>
<body>

<div class="container">
    <h1>☁️ Cloudflare Traffic Control</h1>

    <?php if ($message): ?>
        <div class="alert <?= $messageType ?>"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="grid-section">
            
            <!-- LEFT: Country Whitelist -->
            <div class="panel">
                <h3>🌍 Allowed Countries (Whitelist)</h3>
                <div class="controls">
                    <button type="button" class="btn btn-small" onclick="toggleAll(true)">Select All</button>
                    <button type="button" class="btn btn-small" onclick="toggleAll(false)">Deselect All</button>
                </div>
                <div class="country-grid">
                    <?php foreach ($countries as $code => $name): ?>
                        <label class="country-item">
                            <input type="checkbox" name="countries[]" value="<?= $code ?>" 
                                <?= in_array(strtoupper($code), array_map('strtoupper', $currentCountries)) ? 'checked' : '' ?>>
                            <?= $name ?> (<?= strtoupper($code) ?>)
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- RIGHT: IP Management -->
            <div class="panel">
                <h3>🚫 Block Individual IPs</h3>
                <div class="add-box">
                    <input type="text" id="newIpInput" class="add-input" placeholder="Enter IP (e.g., 1.2.3.4)">
                    <button type="button" class="btn btn-add" onclick="handleAdd('ip')">Add</button>
                </div>
                <table class="ip-table">
                    <thead><tr><th width="40%">IP Address</th><th>Detected Location</th><th width="15%">Action</th></tr></thead>
                    <tbody id="ipTableBody">
                        <!-- JS will populate on load -->
                        <?php foreach($currentIPs as $ip): ?>
                            <script>document.addEventListener('DOMContentLoaded', () => createRow('ip', '<?= $ip ?>'));</script>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>

                <h3>🚫 Block IP Ranges</h3>
                <div class="add-box">
                    <input type="text" id="newRangeInput" class="add-input" placeholder="CIDR (e.g., 192.168.0.0/24)">
                    <button type="button" class="btn btn-add" onclick="handleAdd('range')">Add</button>
                </div>
                <table class="ip-table">
                    <thead><tr><th width="40%">Range</th><th>Info</th><th width="15%">Action</th></tr></thead>
                    <tbody id="rangeTableBody">
                         <?php foreach($currentRanges as $range): ?>
                            <script>document.addEventListener('DOMContentLoaded', () => createRow('range', '<?= $range ?>'));</script>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <button type="submit" class="btn btn-submit">⚡ Update Cloudflare Rules</button>
    </form>
</div>

</body>
</html>
