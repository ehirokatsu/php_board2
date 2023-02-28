<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Services\BoardService;
use App\Http\Repositories\BoardRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(BoardService::class,'App\Http\Services\BoardService');
        $this->app->bind(BoardRepositoryInterface::class,'App\Http\Repositories\BoardRepository');

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
