<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckInController extends Controller
{
	public function index()
	{
		$checkIns = CheckIn::where('user_id', Auth::id())
			->orderBy('date', 'desc')
			->get();

		return view('checkin.index', compact('checkIns'));
	}

	public function create()
	{
		return view('setup.checkin.index');
	}

	public function submit(Request $request)
	{
		$request->validate([
			'challenge' => 'nullable|string|max:255',
			'custom_challenge' => 'nullable|string|max:255',
		]);

		$challenge = $request->input('challenge') ?: $request->input('custom_challenge');

		// Example AI response logic
		$tips = match ($challenge) {
			'Motivasi rendah' => 'Cobalah untuk memulai dengan tugas kecil untuk membangun momentum.',
			'Terlalu banyak pekerjaan' => 'Prioritaskan tugasmu dan fokus pada yang paling penting.',
			'Kurang fokus' => 'Istirahat sejenak dan coba teknik pomodoro untuk meningkatkan fokus.',
			default => 'Tetap semangat! Ingat, setiap tantangan adalah peluang untuk belajar.',
		};

		CheckIn::create([
			'user_id' => Auth::id(),
			'challenge' => $challenge,
			'answer' => $challenge,
			'ai_response' => $tips,
			'mood' => $request->input('mood'),
			'date' => now()->format('Y-m-d'),
		]);

		return view('setup.checkin.response', compact('challenge', 'tips'));
	}

    public function dailyCheckin()
    {
        return view('checkin.daily');
    }

    public function dailyCheckinStore(Request $request)
    {
        $request->validate([
            'answer' => 'required|string|max:255',
        ]);

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyBGXHGhP1mi7uuW29QdqGNkCSjrEnk5w10";

        $body = [
            "system_instruction" => [
                "parts" => [
                    ["text" => "Kamu Pemberi motivasi. Tidak ada teks pembuka atau penutup"],
                    ["text" => "User mengirim pertanyaan yaitu :Apa hal yang paling membanggakan dari hari ini?"],
                    ["text" => "data berupa paragraf 2 kalimat yang mendukung pertanyaan tersebut"],
                    ["text" => "tidak ada jawaban list point , tidak ada tanda - , *"],
                    ["text" => "Scope: Motivasi"]
                ]
            ],
            "contents" => [
                [
                    "parts" => [
                        ["text" => $request->answer]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $body);

        if ($response->successful()) {
            $responseData = $response->json();
            $resMessage = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';

            if ($resMessage) {
                CheckIn::firstOrCreate([
                    'user_id' => Auth::id(),
                    'date' => now()->format('Y-m-d'),
                ],[
                    'answer' => $request->answer,
                    'ai_response' => $resMessage,
                    'mood' => 'Senang',
                ]);
            }

            return $resMessage;
        }

        return null;
    }
}
