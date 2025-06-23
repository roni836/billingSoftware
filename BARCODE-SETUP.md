## Barcode Generator Setup

To enable barcode generation, follow these steps:

1. Install the required packages:
```bash
composer require picqer/php-barcode-generator
```

2. Run the storage link command:
```bash
php artisan storage:link
```

3. Visit the setup URL to create the necessary directories:
```
http://yourdomain.com/setup-barcode-storage
```

4. If you encounter any issues with the Labelary API, the system will automatically fall back to a simpler barcode generation method.