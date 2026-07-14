<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use App\Services\WhatsappService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Setting', \SimpleSoftwareIO\QrCode\Facades\QrCode::class);
        $loader->alias('Excel', \Maatwebsite\Excel\Facades\Excel::class);

        $this->app->bind('whatsapp-service', function ($app) {
            return new WhatsappService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
