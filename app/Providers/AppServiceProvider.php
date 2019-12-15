<?php

namespace App\Providers;

use App\Cart;
use App\View as AppView;
use App\ViewDB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
         view()->composer('*', function ($view)
        {
            $cart = NULL;
            if(Session::get('idCustomer'))
                $cart = Cart::where("CustomerID", "=", Session::get('idCustomer'))
                        ->orWhere('SessionID', Session::getId())->get();
            else
                $cart = Cart::where('SessionID', Session::getId())->get();
            if(Session::get('countedView') == null){
                ViewDB::count();
                Session::put('countedView', true);
            }
            $view->with('cart', $cart );
        });
    }
}
