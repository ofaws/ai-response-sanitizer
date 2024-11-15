<?php

namespace Ofaws\Sanitizer\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Ofaws\Sanitizer\SanitizerServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            SanitizerServiceProvider::class,
        ];
    }
}
