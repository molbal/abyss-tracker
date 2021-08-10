<?php

    namespace App\Providers;

    use App\Connector\EveAPI\EveAPICore;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\ItemClassifier;
    use Illuminate\Pagination\Paginator;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider {
        /**
         * Register any application services.
         *
         * @return void
         */
        public function register() {
            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova');

            $this->app->singleton(ResourceLookupService::class, function ($app) {
                return new ResourceLookupService();
            });

            $this->app->singleton(ItemClassifier::class, function ($app) {
                return new ItemClassifier($app->make(ResourceLookupService::class));
            });
        }

        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot() {
            Paginator::useBootstrap();


        }
    }
