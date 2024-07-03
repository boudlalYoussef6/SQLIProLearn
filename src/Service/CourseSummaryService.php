<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CourseSummaryService
{
    private ParameterBagInterface $params;

    private readonly HttpClientInterface $client;

    public function __construct(
        ParameterBagInterface $params,
        #[Target('aiTogether')]
        HttpClientInterface $client,
        private readonly DecoderInterface $decoder,
    ) {
        $this->params = $params;
        $this->client = $client;
    }

    public function generateSummary(string $content): string
    {
        $response = $this->client->request('POST', '/v1/chat/completions', [
            'json' => [
                'model' => 'Qwen/Qwen2-72B-Instruct',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $this->generateSummaryContent($content),
                    ],
                ],
            ],
        ]);

        $content = $response->getContent();

        $data = $this->decoder->decode($content, 'json');

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
