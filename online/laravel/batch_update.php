<?php
$directory = 'f:/xampp/htdocs/bank/online/laravel/resources/views/';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

$exclude = [
    'header.blade.php',
    'footer.blade.php',
    'sidebar.blade.php',
    'topNav.blade.php',
    'index.blade.php',
    'own-account-transfer.blade.php',
    'transfer-to-same-bank.blade.php',
    'transfer-to-other-bank.blade.php',
    'account-quicklook.blade.php',
    'accounts-summary.blade.php'
];

$replacements = [
    // Remove the legacy wrapper classes entirely, since they are handled globally now
    '/<div\s+id="content-page"\s+class="content-page">/' => '<div>',
    '/<div\s+class="container-fluid">/' => '<div class="max-w-7xl mx-auto w-full">',
    
    // Cards
    '/class="iq-card"/' => 'class="bg-surface rounded-2xl shadow-level-1 border border-outline-variant/30 mb-lg overflow-hidden"',
    '/class="iq-card-header\s+d-flex\s+justify-content-between"/' => 'class="p-lg border-b border-outline-variant/30 flex justify-between items-center"',
    '/class="iq-card-header"/' => 'class="p-lg border-b border-outline-variant/30 flex justify-between items-center"',
    '/class="iq-card-body"/' => 'class="p-lg"',
    '/class="iq-header-title"/' => 'class="mb-2"',
    '/class="card-title"/' => 'class="text-headline-sm font-headline-sm text-on-surface font-semibold"',
    '/class="iq-card-title"/' => 'class="text-headline-sm font-headline-sm text-on-surface font-semibold"',
    
    // Rows & Columns (Bootstrap Grid -> Tailwind Flex/Grid equivalents for common sizes)
    '/class="row"/' => 'class="flex flex-wrap -mx-3"',
    '/class="col-sm-12\s+col-lg-12"/' => 'class="w-full px-3"',
    '/class="col-lg-12"/' => 'class="w-full px-3"',
    '/class="col-lg-6"/' => 'class="w-full lg:w-1/2 px-3"',
    '/class="col-sm-12\s+col-lg-6"/' => 'class="w-full lg:w-1/2 px-3"',
    '/class="col-lg-4"/' => 'class="w-full lg:w-1/3 px-3"',
    '/class="col-sm-12"/' => 'class="w-full px-3"',
    '/class="col-md-6"/' => 'class="w-full md:w-1/2 px-3"',
    
    // Forms
    '/class="form-group"/' => 'class="mb-4"',
    '/class="form-control"/' => 'class="bg-surface-container-low border border-transparent rounded-lg py-3 px-4 w-full text-on-surface font-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all"',
    '/<label\s+for="(.*?)"([^>]*)>/' => '<label for="$1" class="block text-sm font-semibold text-on-surface-variant mb-2">',
    '/<label([^>]*)>/' => '<label class="block text-sm font-semibold text-on-surface-variant mb-2">',
    
    // Buttons
    '/class="btn\s+btn-primary"/' => 'class="bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2"',
    '/class="btn\s+btn-success"/' => 'class="bg-secondary hover:bg-secondary/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2"',
    '/class="btn\s+btn-danger"/' => 'class="bg-error hover:bg-error/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2"',
    '/class="btn\s+btn-warning"/' => 'class="bg-tertiary-container hover:bg-tertiary-container/90 text-on-tertiary-container font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2"',
    '/class="btn\s+btn-info"/' => 'class="bg-surface-tint hover:bg-surface-tint/90 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center justify-center gap-2"',
    
    // Tables
    '/<table\s+class="(.*?)"/' => '<table class="w-full text-left border-collapse"',
    '/<thead\s+class="(.*?)"/' => '<thead class="bg-surface-container-low text-on-surface-variant font-semibold"',
    '/<thead/' => '<thead class="bg-surface-container-low text-on-surface-variant font-semibold"',
    '/<th/' => '<th class="p-4 border-b border-surface-container-high text-sm whitespace-nowrap"',
    '/<td/' => '<td class="p-4 border-b border-surface-container-high text-sm text-on-surface"',
    
    // Margin & Padding
    '/mt-3/' => 'mt-4',
    '/mb-3/' => 'mb-4',
    '/mt-4/' => 'mt-6',
    '/mb-4/' => 'mb-6',
    
    // Badges / Alerts
    '/badge\s+badge-primary/' => 'bg-primary-container text-on-primary-container px-2 py-1 rounded-full text-xs font-semibold',
    '/badge\s+badge-success/' => 'bg-[#E6F4EA] text-[#137333] px-2 py-1 rounded-full text-xs font-semibold',
    '/badge\s+badge-danger/' => 'bg-error-container text-on-error-container px-2 py-1 rounded-full text-xs font-semibold',
    '/badge\s+badge-warning/' => 'bg-[#FEF7E0] text-[#B06000] px-2 py-1 rounded-full text-xs font-semibold',
    '/badge\s+badge-info/' => 'bg-[#E8F0FE] text-[#1967D2] px-2 py-1 rounded-full text-xs font-semibold',
    
    '/alert\s+alert-primary/' => 'bg-primary-container text-on-primary-container p-4 rounded-lg',
    '/alert\s+alert-success/' => 'bg-[#E6F4EA] text-[#137333] p-4 rounded-lg',
    '/alert\s+alert-danger/' => 'bg-error-container text-on-error-container p-4 rounded-lg',
    
    // Text Colors
    '/text-danger/' => 'text-error',
    '/text-success/' => 'text-secondary',
    '/text-primary/' => 'text-primary',
    '/text-muted/' => 'text-outline',
    
    // Icons (LineAwesome -> Material Symbols)
    '/<i\s+class="las\s+la-home[^"]*"><\/i>/' => '<span class="material-symbols-outlined">home</span>',
    '/<i\s+class="las\s+la-user[^"]*"><\/i>/' => '<span class="material-symbols-outlined">person</span>',
    '/<i\s+class="las\s+la-money-bill[^"]*"><\/i>/' => '<span class="material-symbols-outlined">payments</span>',
    '/<i\s+class="las\s+la-credit-card[^"]*"><\/i>/' => '<span class="material-symbols-outlined">credit_card</span>',
    '/<i\s+class="las\s+la-plus[^"]*"><\/i>/' => '<span class="material-symbols-outlined">add</span>',
    '/<i\s+class="las\s+la-edit[^"]*"><\/i>/' => '<span class="material-symbols-outlined">edit</span>',
    '/<i\s+class="las\s+la-trash[^"]*"><\/i>/' => '<span class="material-symbols-outlined">delete</span>',
    '/<i\s+class="las\s+la-check[^"]*"><\/i>/' => '<span class="material-symbols-outlined">check</span>',
    '/<i\s+class="las\s+la-times[^"]*"><\/i>/' => '<span class="material-symbols-outlined">close</span>',
    '/<i\s+class="las\s+la-eye[^"]*"><\/i>/' => '<span class="material-symbols-outlined">visibility</span>',
];

$count = 0;

foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php' && strpos($file->getFilename(), '.blade.php') !== false) {
        $skip = false;
        foreach ($exclude as $ex) {
            if ($file->getFilename() === $ex) {
                $skip = true;
                break;
            }
        }
        if ($skip) continue;

        $content = file_get_contents($file->getRealPath());
        $original = $content;
        
        foreach ($replacements as $pattern => $replacement) {
            $content = preg_replace($pattern, $replacement, $content);
        }
        
        if ($content !== $original) {
            file_put_contents($file->getRealPath(), $content);
            $count++;
            echo "Updated: " . $file->getFilename() . "\n";
        }
    }
}

echo "Total files updated: $count\n";
?>
