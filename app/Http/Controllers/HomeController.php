<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function index()
	{
		$user = Auth::user();
		
		// Fetch habits, check-ins, and goals
		$habits = $user->habits;
		$checkIns = $user->checkIns()->latest()->take(10)->get();
		$goals = $user->goals;
		
		// Calculate habit streak
		$streak = $this->calculateHabitStreak($user);
		
		// Weekly check-ins count
		$checkInsThisWeek = $user->checkIns()
			->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
			->count();
		
		// Daily motivation (example static message or fetched dynamically)
		$dailyMotivation = "Stay consistent and keep pushing forward!";
		
		return view('home', compact('habits', 'checkIns', 'goals', 'streak', 'checkInsThisWeek', 'dailyMotivation'));
	}
	
	private function calculateHabitStreak($user)
	{
		$streak = 0;
		
		// Ambil check-ins dan kelompokkan berdasarkan tanggal (tanpa waktu)
		$checkIns = $user->checkIns()
			->orderBy('date', 'desc')
			->get()
			->groupBy(function ($checkIn) {
				return Carbon::make($checkIn->date)->toDateString(); // Kelompokkan berdasarkan tanggal
			});
		
		$dates = $checkIns->keys(); // Ambil daftar tanggal unik
		
		foreach ($dates as $index => $date) {
			if ($index === 0 || $date->diffInDays($dates[$index - 1]) === 1) {
				$streak++;
			} else {
				break;
			}
		}
		
		return $streak;
	}
}
