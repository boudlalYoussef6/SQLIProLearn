<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class CourseSummaryService
{
    private ParameterBagInterface $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function generateSummary(string $description): string
    {
        $apiKey = $this->params->get('TOGETHER_API_KEY');

        $apiUrl = 'https://api.together.xyz/v1/chat/completions';
        $httpClient = HttpClient::create();
        $response = $httpClient->request('POST', $apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer '.$apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'Qwen/Qwen2-72B-Instruct',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $this->generateSummaryContent($description),
                    ],
                ],
            ],
        ]);

        $data = json_decode($response->getContent(), true);

        return $data['choices'][0]['message']['content'];
    }

    private function generateSummaryContent(string $description): string
    {
        $randomString = bin2hex(random_bytes(5));

        return sprintf(
            'donner résumé de cette Description: %s. Aléatoire: %s',
            $description,
            $randomString
        );
    }
}
