<?

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
        $apiKey = config('services.openai.key');
        $client = new Client();


        $response = $client->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyBGXHGhP1mi7uuW29QdqGNkCSjrEnk5w10', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'system_instruction' => [
                    'parts' => [
                        // Format Array Json, key nya habit, strategy
                        ['text' => 'MyCoachAi: Berikan output JSON array berisi daftar list dari goals. Tidak ada teks pembuka atau penutup.'],
                        ['text' => 'Format Json, key nya habbit, strategy'],
                        ['text' => '10 List data'],
                        ['text' => 'Scope: Pola Hidup Sehat, produktifitas kesehatan, olahraga'],
                    ],
                ],
                'contents' => [
                    [
                        'parts' => [
                            ['text' => 'naikin berat badan 5 kg dalam 1 bulan  '],
                        ],
                    ],
                ],
            ],
        ]);

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);
        // return $data;
        $dataResult = $data['candidates'][0]['content']['parts'][0]['text'];
        info(gettype($dataResult));
        return $dataResult[5];
    }
}
