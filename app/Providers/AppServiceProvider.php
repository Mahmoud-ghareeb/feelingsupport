<?php

namespace App\Providers;

use ConsoleTVs\Charts\Registrar as Charts;
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
        $this->app->bind('path.public', function() {
            return base_path();
          });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            \App\Charts\DailyChart::class,
            \App\Charts\DailyChartApi::class,
            \App\Charts\EmojiChart::class,
            \App\Charts\EmojiChartApi::class,
            \App\Charts\CompareChart::class,
            \App\Charts\CompareChartApi::class,
            \App\Charts\EgabiChart::class,
            \App\Charts\EgabiChartApi::class
        ]);
    }
}
