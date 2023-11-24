<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        JsonResource::withoutWrapping();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // \Inertia\Inertia::share([
        //     'errors' => function () {
        //         return \Session::get('errors')
        //             ? \Session::get('errors')->getBag('default')->getMessages()
        //             : (object) [];
        //     }
        // ]);
    }
}
