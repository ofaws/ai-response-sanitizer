<?php

namespace Ofaws\Sanitizer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SanitizerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('ai-response-sanitizer');
            //->hasConfigFile('sanitizer');
    }
}
