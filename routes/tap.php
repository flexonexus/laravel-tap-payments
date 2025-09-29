<?php

use Illuminate\Support\Facades\Route;
use FlexoNexus\Tap\Webhooks\TapWebhookController;

Route::post('/tap/webhook', TapWebhookController::class)->name('tap.webhook');
