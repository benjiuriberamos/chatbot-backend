<?php

namespace App\Services\OpenAi;

use OpenAI;
use OpenAI\Client;

class OpenaiService
{
    protected ?Client $client;

    public function __construct()
    {
        $yourApiKey = getenv('OPENAI_API_KEY');
        $this->client = OpenAI::client($yourApiKey);
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function process(string $message): string
    {
        if (!$message) return 'Ingrese un mensaje';

        $result = $this->client->chat()->create([
            'model' => getenv('OPENAI_MODEL'),
            'messages' => [
                ['role' => 'system', 'content' => 'Eres una asistente de cursos cursos de Platzi.'],
                ['role' => 'user', 'content' => $message],
            ],
            'max_tokens' => 200,
            'temperature' => 0.5
        ]);
        return $result->choices[0]->message->content;
    }
}
