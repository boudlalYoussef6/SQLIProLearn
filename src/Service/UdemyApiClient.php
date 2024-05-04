<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class UdemyApiClient
{
    private $client;
    private $clientId;
    private $clientSecret;

    public function __construct(HttpClientInterface $client, string $clientId, string $clientSecret)
    {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getCourses(): array
    {
        $endpoint = 'https://www.udemy.com/api-2.0/courses/';

        $response = $this->client->request('GET', $endpoint, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            ],
        ]);

        return $response->toArray();
    }
}
