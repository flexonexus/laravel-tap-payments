<?php

use Orchestra\Testbench\TestCase;
use FlexoNexus\Tap\TapServiceProvider;
use FlexoNexus\Tap\Http\TapClient;

class TapClientTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [TapServiceProvider::class];
    }

    /** @test */
    public function it_instantiates_client()
    {
        $client = $this->app->make(TapClient::class);
        $this->assertInstanceOf(TapClient::class, $client);
    }
}
