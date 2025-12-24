<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $loader = AliasLoader::getInstance();

        // Add your aliases
        $loader->alias('Qrcode', \SimpleSoftwareIO\QrCode\Facades\QrCode::class);
    }
}
