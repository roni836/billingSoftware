<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Products;
use App\Http\Livewire\ProductCategories;
use App\Http\Livewire\Purchases;
use App\Http\Livewire\Sales;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Storage link route
Route::get('/linkstorage', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'Storage link created successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::get('/products', function () {
    return view('products');
})->name('products');

Route::get('/products/create', function () {
    return view('products.create');
})->name('products.create');

Route::get('/products/{product}/edit', function ($product) {
    return view('products.create', ['product_id' => $product]);
})->name('products.edit');

Route::get('/products/{product}/barcode', function ($product) {
    return view('products.barcode', ['product_id' => $product]);
})->name('products.barcode');

// Utility route to create barcode directory and storage link
Route::get('/setup-barcode-storage', function () {
    try {
        // Create storage link if it doesn't exist
        if (!file_exists(public_path('storage'))) {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
        }
        
        // Create barcode directory
        $path = storage_path('app/public/barcodes');
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        
        return 'Barcode storage setup complete! The directory has been created at: ' . $path;
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Fallback barcode generation (direct PNG)
Route::get('/products/{product}/generate-barcode', 'App\Http\Controllers\BarcodeController@generateBarcode')->name('products.generate-barcode');

Route::get('/product-categories', function () {
    return view('product-categories');
})->name('product-categories');

Route::get('/purchases', function () {
    return view('purchases');
})->name('purchases');

Route::get('/sales', function () {
    return view('sales');
})->name('sales');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/customers', function () {
    return view('customers');
})->name('customers');

Route::get('/reports', function () {
    return view('reports');
})->name('reports');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');
