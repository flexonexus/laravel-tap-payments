<?php

namespace FlexoNexus\Tap\Facades;

use Illuminate\Support\Facades\Facade;

class Tap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \FlexoNexus\Tap\Contracts\TapGateway::class;
    }
}
