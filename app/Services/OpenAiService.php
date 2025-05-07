<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class OpenAiService
{
    public static function make()
    {
        return new static;
    }

    public function getResponse(string $userInput)
    {
        $client = new Client();
        $apiKey = env('ai_key');
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

        $response = $client->post("$url?key=$apiKey", [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'system_instruction' => [
                    'parts' => [
                        ['text' => 'MyCoachAi: Berikan output JSON array berisi daftar list dari goals. Tidak ada teks pembuka atau penutup.'],
                        ['text' => 'Format Json, key nya habbit, strategy'],
                        ['text' => '10 List data'],
                        ['text' => 'Scope: Pola Hidup Sehat, produktifitas kesehatan, olahraga'],
                    ],
                ],
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $userInput],
                        ],
                    ],
                ],
            ],
        ]);

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);
        $dataResult = $data['candidates'][0]['content']['parts'][0]['text'];

        $cleaned = trim($dataResult);
        $cleaned = preg_replace('/^```json|```$/', '', $cleaned);
        $cleaned = trim($cleaned);

        return json_decode($cleaned, true);
    }
}
