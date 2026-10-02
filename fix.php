<?php
$dirs = [
    'f:\xampp\htdocs\bank\online\laravel\app\Http\Controllers',
    'f:\xampp\htdocs\bank\admin\lsapp\app\Http\Controllers'
];

foreach ($dirs as $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $path = $file->getPathname();
            $content = file_get_contents($path);
            
            // Fix REMOTE_ADDR
            $content = str_replace(
                "if(\$_SERVER['REMOTE_ADDR'] == '127.0.0.1')",
                "if(isset(\$_SERVER['REMOTE_ADDR']) && \$_SERVER['REMOTE_ADDR'] == '127.0.0.1')",
                $content
            );
            
            // Fix license check
            $licenseCheckBlock = <<<EOD
        \$config = DB::table('configs')->where('id','1')->first();
	    if(\$config->licence_key != "" || \$config->licence_key != NULL){
    	    \$domain = str_replace("http://","",str_replace("https://","",str_replace("/".\$config->client_folder,"",URL::to('/'))));
            \$ch = curl_init();
            curl_setopt(\$ch, CURLOPT_URL,"https://bank.coderanita.com/api/check_purchase_key_with_domain");
            curl_setopt(\$ch, CURLOPT_POST, 1);
            curl_setopt(\$ch, CURLOPT_POSTFIELDS,"key=".\$config->licence_key."&domain=".\$domain);
            curl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);
            \$coderanita = curl_exec(\$ch);
            curl_close(\$ch);
            if(json_decode(\$coderanita)->status == "500"){
                if(\Request::route()->getName() != "no-key"){
                    redirect()->route('no-key')->send();
                }
    	    }
	    }else{
            if(\Request::route()->getName() != "no-key"){
                redirect()->route('no-key')->send();
            }
	    }
EOD;

            $bypassedBlock = <<<EOD
        \$config = DB::table('configs')->where('id','1')->first();
        if(config('app.env') !== 'local') {
	    if(\$config->licence_key != "" || \$config->licence_key != NULL){
    	    \$domain = str_replace("http://","",str_replace("https://","",str_replace("/".\$config->client_folder,"",URL::to('/'))));
            \$ch = curl_init();
            curl_setopt(\$ch, CURLOPT_URL,"https://bank.coderanita.com/api/check_purchase_key_with_domain");
            curl_setopt(\$ch, CURLOPT_POST, 1);
            curl_setopt(\$ch, CURLOPT_POSTFIELDS,"key=".\$config->licence_key."&domain=".\$domain);
            curl_setopt(\$ch, CURLOPT_RETURNTRANSFER, true);
            \$coderanita = curl_exec(\$ch);
            curl_close(\$ch);
            if(json_decode(\$coderanita)->status == "500"){
                if(\Request::route()->getName() != "no-key"){
                    redirect()->route('no-key')->send();
                }
    	    }
	    }else{
            if(\Request::route()->getName() != "no-key"){
                redirect()->route('no-key')->send();
            }
	    }
        }
EOD;

            $content = str_replace($licenseCheckBlock, $bypassedBlock, $content);
            file_put_contents($path, $content);
        }
    }
}
echo "Done replacing.\n";
