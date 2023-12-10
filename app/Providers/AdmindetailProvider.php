<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Admindetail;

class AdmindetailProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('Admindetail',function(){
            return new Admindetail;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
