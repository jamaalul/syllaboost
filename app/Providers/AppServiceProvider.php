<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
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
        Event::listen(function (Login $event) {
            if ($event->user instanceof \App\Models\User) {
                $event->user->forceFill([
                    'last_login_at' => now(),
                ])->save();
            }
        });

        View::composer(['layouts.dashboard'], function ($view) {
            $user = Auth::user()?->load([
                'folders:id,user_id,name,slug',
            ]);

            $view->with('user', $user);
        });
    }
}
