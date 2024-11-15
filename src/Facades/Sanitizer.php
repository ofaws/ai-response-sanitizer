<?php

namespace Ofaws\Sanitizer\Facades;

use Illuminate\Support\Facades\Facade;

class Sanitizer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ofaws\Sanitizer\Sanitizer::class;
    }
}