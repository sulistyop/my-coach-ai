<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
