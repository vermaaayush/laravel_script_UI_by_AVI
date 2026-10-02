<?php
$dir = new RecursiveDirectoryIterator('f:\xampp\htdocs\bank\online\laravel\resources\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $original = $content;

    // Remove the modernized popup and footer text block
    $pattern = '/<!-- Footer Loan Text & Popups -->\s*<div class="bg-surface rounded-xl shadow-level-1 p-md border border-outline-variant\/30 mt-md">.*?<\?= \$footerOfTransfer->loan_landing_text \?>\s*<\/p>\s*<\?php \} \?>\s*<\/div>/s';
    $content = preg_replace($pattern, '', $content);
    
    // Also remove the PHP assignment block if it's left behind
    $pattern2 = '/<\?php\s*\$confiG\s*=\s*DB::table\(\'configs\'\)->where\(\'id\',\'1\'\)->first\(\);\s*\$popupsN\s*=\s*DB::table\(\'ba_pop_pages\'\)->orderby\(\'id\',\'asc\'\)->get\(\);\s*\$footerOfTransfer\s*=\s*DB::table\(\'ba_extras\'\)->where\(\'id\',\'2\'\)->first\(\);\s*\?>/s';
    $content = preg_replace($pattern2, '', $content);
    
    // Sometimes it's just footerOfTransfer
    $pattern3 = '/<\?php\s*\$footerOfTransfer = DB::table\(\'ba_extras\'\)->where\(\'id\',\'2\'\)->first\(\);\s*\?>/s';
    $content = preg_replace($pattern3, '', $content);

    // Another variant of the block without the comment
    $pattern4 = '/<div class="bg-surface rounded-xl shadow-level-1 p-md border border-outline-variant\/30 mt-md">\s*<ul class="flex flex-wrap gap-sm mb-4">.*?<\?= \$footerOfTransfer->loan_landing_text \?>\s*<\/p>\s*<\?php \} \?>\s*<\/div>/s';
    $content = preg_replace($pattern4, '', $content);

    // Some definitions are intermixed:
    $pattern5 = '/\$footerOfTransfer\s*=\s*DB::table\(\'ba_extras\'\)->where\(\'id\',\'2\'\)->first\(\);/s';
    $content = preg_replace($pattern5, '', $content);
    
    // Cleanup empty php tags
    $content = preg_replace('/<\?php\s*\?>/', '', $content);

    if ($original !== $content) {
        file_put_contents($path, $content);
        $count++;
        echo "Cleaned modernized: $path\n";
    }
}
echo "Total modernized files cleaned: $count\n";
?>
