<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		$habits = Habit::where('user_id', $user->id)->get();
		$streak = $habits->sum('current_streak');
		$checkInsThisWeek = CheckIn::where('user_id', $user->id)
			->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
			->count();
		$dailyMotivation = "Stay consistent!";
		
		return view('dashboard', compact('habits', 'streak', 'checkInsThisWeek', 'dailyMotivation'));
	}
}
