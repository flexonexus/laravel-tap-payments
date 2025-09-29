<?php

namespace FlexoNexus\Tap\Services;

use FlexoNexus\Tap\Contracts\TapGateway;
use FlexoNexus\Tap\Http\TapClient;

class TapGatewayImpl implements TapGateway
{
    public function __construct(protected TapClient $client) {}

    public function createCharge(array $payload): array
    {
        // Tap typically uses /charges
        return $this->client->post('charges', $payload);
    }

    public function retrieveCharge(string $chargeId): array
    {
        return $this->client->get("charges/{$chargeId}");
    }

    public function captureCharge(string $chargeId, ?array $payload = null): array
    {
        $payload ??= [];
        return $this->client->post("charges/{$chargeId}/capture", $payload);
    }

    public function refundCharge(string $chargeId, array $payload): array
    {
        return $this->client->post("refunds", $payload);
    }
}
