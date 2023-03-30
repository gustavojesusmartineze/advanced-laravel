<?php

namespace App\Providers;

use App\Models\Rating;
use Illuminate\View\View;
use App\Http\Resources\RatingResource;
use Illuminate\Support\ServiceProvider;

class RatingProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('home', function(View $view) {
            $view->with('rating', RatingResource::collection(Rating::all()));
        });
    }
}
