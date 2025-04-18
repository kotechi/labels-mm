<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share out of stock count with all views that use the layouts
        View::composer(['*'], function ($view) {
            $outOfStockCount = Product::where('stock_product', 0)->count();
            $view->with('outOfStockCount', $outOfStockCount);
        });
    }
}