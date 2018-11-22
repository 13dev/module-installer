<?php

namespace Dev13\ModuleInstaller\Tests;

use Dev13\ModuleInstaller\ModuleInstallerServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class PackageTestCase extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [ModuleInstallerServiceProvider::class];
    }
}
