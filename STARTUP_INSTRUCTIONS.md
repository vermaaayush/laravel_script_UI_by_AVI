# Startup Instructions

To start the project correctly, run the following commands:

1. **Start the PHP Router (Serves both Admin & Online):**
   Run from the `bank` root directory (`f:\xampp\htdocs\bank`):
   ```bash
   php -S 127.0.0.1:8000 router.php
   ```
   This will serve:
   - `https://ibank.firstallianzgroup.com/online`
   - `https://ibank.firstallianzgroup.com/admin`

2. **Start the Laravel Mix Watcher (for Frontend Assets):**
   Run from the `bank/online/laravel` directory:
   ```bash
   npm run watch
   ```
