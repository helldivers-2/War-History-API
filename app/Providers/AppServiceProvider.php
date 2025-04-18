<?php

namespace App\Providers;

use ErrorException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Collection::macro('OneEntryArrayList', function () {
            return $this->map(function ($item) {
                try {
                    return $item[0];
                } catch (ErrorException) {
                    return null;
                }
            });
        });
    }
}
