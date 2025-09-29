<?php

namespace FlexoNexus\Tap\Support;

use Illuminate\Support\Str;

class Signature
{
    /**
     * Example HMAC verification. Adjust header name/algorithm per Tap docs.
     */
    public static function verify(string $payload, string $signature, string $secret, ?int $timestamp = null, int $tolerance = 300): bool
    {
        if ($timestamp) {
            $now = time();
            if (abs($now - $timestamp) > $tolerance) {
                return false;
            }
        }

        $computed = hash_hmac('sha256', $payload, $secret);
        // time-safe compare
        return hash_equals($computed, $signature);
    }
}
