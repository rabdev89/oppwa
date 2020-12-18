<?php

namespace Rabcreatives\Oppwa\Facades;

use Illuminate\Support\Facades\Facade;

class Oppwa extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Oppwa';
    }
}
