<?php
$log_path = 'C:\Users\Desktop\.gemini\antigravity-ide\brain\203d848d-499c-4aa6-8f13-3869b0244873\.system_generated\logs\transcript.jsonl';
$target_file = 'f:\xampp\htdocs\bank\online\laravel\app\Http\Controllers\DepositController.php';

$handle = fopen($log_path, 'r');
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $data = json_decode($line, true);
        if (isset($data['type']) && $data['type'] === 'VIEW_FILE' && strpos($data['content'] ?? '', 'DepositController.php') !== false) {
            $lines = explode("\n", $data['content']);
            $output = [];
            $capturing = false;
            foreach ($lines as $l) {
                if (strpos($l, '42:         if(isset(<?php') === 0) {
                    $output[] = '<?php';
                    $capturing = true;
                } elseif ($capturing) {
                    if (strpos($l, '295: }SERVER') === 0) {
                        break;
                    }
                    $idx = strpos($l, ': ');
                    if ($idx !== false && is_numeric(substr($l, 0, $idx))) {
                        $output[] = substr($l, $idx + 2);
                    } else {
                        $output[] = $l;
                    }
                }
            }
            if (!empty($output)) {
                // Ensure the config bypass is added to the recovered file
                $content = implode("\n", $output);
                
                // Fix REMOTE_ADDR check safely
                $content = preg_replace('/if\s*\(\s*\$_SERVER\[\'REMOTE_ADDR\'\]\s*==\s*\'127\.0\.0\.1\'\s*\)/', "if(isset(\$_SERVER['REMOTE_ADDR']) && \$_SERVER['REMOTE_ADDR'] == '127.0.0.1')", $content);

                // Fix the license check block to bypass on local environment
                $licensePattern = '/\$config\s*=\s*DB::table\(\'configs\'\)->where\(\'id\',\'1\'\)->first\(\);\s*if\(\$config->licence_key\s*!=\s*""\s*\|\|\s*\$config->licence_key\s*!=\s*NULL\)\{/s';
                
                if (preg_match($licensePattern, $content)) {
                    $replacement = "\$config = DB::table('configs')->where('id','1')->first();\n        if(config('app.env') !== 'local') {\n        if(\$config->licence_key != \"\" || \$config->licence_key != NULL){";
                    $content = preg_replace($licensePattern, $replacement, $content);
                    $content = preg_replace("/(redirect\(\)->route\('no-key'\)->send\(\);\s*\}\s*\})/s", "$1\n        }", $content);
                }
                
                file_put_contents($target_file, $content);
                echo "Recovered DepositController.php\n";
            }
            break;
        }
    }
    fclose($handle);
}
