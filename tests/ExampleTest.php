<?php

namespace Amyisme13\UltraHelper\Tests;

use Orchestra\Testbench\TestCase;
use Amyisme13\UltraHelper\UltraHelperServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [UltraHelperServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
