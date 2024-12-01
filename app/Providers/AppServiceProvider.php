<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\DeshboardMenu;
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
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        View::composer('*', function($view)
        {
            $navbars = DeshboardMenu::where('menu_perent', '=', 0)->orderBy('menu_short')->get();
            $allMenus = DeshboardMenu::pluck('menu_name','id')->all();
            $view->with('navbars', $navbars)
                ->with('allmenus',$allMenus);
        });
    }
}
