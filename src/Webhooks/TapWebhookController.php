<?php

namespace FlexoNexus\Tap\Webhooks;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use FlexoNexus\Tap\Support\Signature;
use Illuminate\Support\Facades\Log;

class TapWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $secret    = config('tap.webhook_secret');
        $tolerance = (int) config('tap.tolerance', 300);

        $payload   = $request->getContent();
        $signature = $request->header('Tap-Signature', '');   // adjust if different
        $timestamp = (int) $request->header('Tap-Timestamp', 0);

        if (!$secret || !Signature::verify($payload, $signature, $secret, $timestamp, $tolerance)) {
            Log::warning('Tap webhook signature verification failed');
            abort(400, 'Invalid signature');
        }

        $event = $request->input('type', 'unknown');

        // Dispatch a Laravel event for your app to listen to:
        event("tap::{$event}", $request->all());

        // Or you can map to explicit Events/Listeners if you prefer.
        return response()->json(['received' => true]);
    }
}
