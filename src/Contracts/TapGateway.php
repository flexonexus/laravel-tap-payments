<?php

namespace FlexoNexus\Tap\Contracts;

interface TapGateway
{
    /**
     * Create a charge (or payment intent) on Tap.
     * Payload mirrors Tap API (amount, currency, customer, source, redirect, etc.).
     */
    public function createCharge(array $payload): array;

    /** Retrieve charge by id */
    public function retrieveCharge(string $chargeId): array;

    /** Capture an authorized charge (if Tap supports capture) */
    public function captureCharge(string $chargeId, ?array $payload = null): array;

    /** Refund a charge */
    public function refundCharge(string $chargeId, array $payload): array;
}
