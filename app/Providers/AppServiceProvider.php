<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use App\Http\Livewire\Products;
use App\Http\Livewire\ProductCategories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        
        // Register Livewire Components
        Livewire::component('products', Products::class);
        Livewire::component('product-categories', ProductCategories::class);
        Livewire::component('product-form', \App\Http\Livewire\ProductForm::class);
        Livewire::component('product-barcode', \App\Http\Livewire\ProductBarcode::class);
        
        // Custom error directive for handling Livewire validation errors
        Blade::directive('errorMessage', function ($expression) {
            return "<?php if (isset(\$errors) && \$errors->has($expression)): ?>
                <span class=\"text-red-500 text-xs\"><?php echo \$errors->first($expression); ?></span>
            <?php endif; ?>";
        });
    }
}
