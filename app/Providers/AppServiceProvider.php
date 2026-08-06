<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\URL;

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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        Blueprint::macro('defaultEngine', function () {
        $this->engine = 'InnoDB';
    });

    Schema::blueprintResolver(function ($table, $callback) {
        return new class($table, $callback) extends Blueprint {
            public function __construct($table, $callback = null)
            {
                parent::__construct($table, $callback);

                $this->engine = 'InnoDB';
            }
        };
    });
        //
        Schema::defaultStringLength(191);
    }
}
