<?php
    // Set execution time limit (optional)
    set_time_limit(300);
    
    // Run Laravel cache clear commands
    echo shell_exec('php artisan cache:clear');
    echo shell_exec('php artisan config:clear');
    echo shell_exec('php artisan config:cache');
    echo shell_exec('php artisan route:clear');
    echo shell_exec('php artisan view:clear');

    echo "Cache cleared successfully!";
?>
