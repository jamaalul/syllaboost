<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        View::composer(['layouts.dashboard'], function ($view) {
            $user = Auth::user()?->load([
                'folders:id,user_id,name,slug',
            ]);

            $view->with('user', $user);
        });
    }
}
