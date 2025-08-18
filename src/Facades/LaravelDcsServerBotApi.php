<?php

namespace Pschilly\LaravelDcsServerBotApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pschilly\LaravelDcsServerBotApi\LaravelDcsServerBotApi
 */
class LaravelDcsServerBotApi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Pschilly\LaravelDcsServerBotApi\LaravelDcsServerBotApi::class;
    }
}
