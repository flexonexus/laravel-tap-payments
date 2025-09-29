<?php

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Route;

class WebhookTest extends TestCase
{
    protected function defineEnvironment($app)
    {
        $app['config']->set('tap.webhook_secret', 'secret');
    }

    /** @test */
    public function rejects_bad_signature()
    {
        $this->post('/tap/webhook', ['type' => 'charge.succeeded'], ['Tap-Signature' => 'bad'])
            ->assertStatus(400);
    }
}
