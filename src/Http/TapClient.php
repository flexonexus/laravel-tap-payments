<?php

namespace FlexoNexus\Tap\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TapClient
{
    protected Client $client;

    public function __construct(string $baseUri, string $secretKey)
    {
        $this->client = new Client([
            'base_uri' => rtrim($baseUri, '/').'/',
            'headers'  => [
                'Authorization' => 'Bearer '.$secretKey,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ],
            'timeout' => 30,
        ]);
    }

    public function get(string $uri, array $query = []): array
    {
        return $this->request('GET', $uri, ['query' => $query]);
    }

    public function post(string $uri, array $json = []): array
    {
        return $this->request('POST', $uri, ['json' => $json]);
    }

    public function delete(string $uri): array
    {
        return $this->request('DELETE', $uri);
    }

    protected function request(string $method, string $uri, array $options = []): array
    {
        try {
            $res = $this->client->request($method, ltrim($uri, '/'), $options);
            return json_decode((string) $res->getBody(), true) ?? [];
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Tap API error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }
}
