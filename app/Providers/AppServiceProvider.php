<?php

namespace App\Providers;

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

    $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        if(env('APP_DEBUG')) {
//            DB::listen(function($query) {
////                File::append(
////                    storage_path('/logs/query.log'),
////                    $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
////                );
//
//                Log::channel("query")->info($query->time."ms ".$query->sql." ".implode(",", $query->bindings));
//            });
//        }
    }
}
