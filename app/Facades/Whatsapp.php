<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool sendText(string $to, string $message)
 * @method static bool sendTemplate(string $to, string $templateName, array $parameters = [], string $language = 'id')
 */
class Whatsapp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'whatsapp-service';
    }
}
