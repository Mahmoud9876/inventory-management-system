<?php

namespace App\Providers;

use Illuminate\Http\Request;
use App\Breadcrumbs\Breadcrumbs;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Observers\ProductObserver;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        Paginator::useBootstrapFive();

        Request::macro('breadcrumbs', function (){
            return new Breadcrumbs($this);
        });

        View::composer('*', function($view) {
            $view->with('products_alert' , Product::whereColumn('quantity', '<=', 'quantity_alert')->get());
        });
        
    }
}
