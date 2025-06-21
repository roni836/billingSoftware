<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Products;
use App\Http\Livewire\Purchases;
use App\Http\Livewire\Sales;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/products', Products::class)->name('products');
    Route::get('/purchases', Purchases::class)->name('purchases');
    Route::get('/sales', Sales::class)->name('sales');
});
