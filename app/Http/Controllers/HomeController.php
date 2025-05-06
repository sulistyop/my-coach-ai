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
		
		$today = now();
		$startOfMonth = $today->copy()->startOfMonth();
		$endOfMonth = $today->copy()->endOfMonth();
		$habits = $user->habits;
		$checkIns = $user->checkIns()->latest()->take(10)->get();
		$goals = $user->goals;
		
		// Ambil semua tanggal check-in bulan ini
		$checkInDates = $user->checkIns()
			->whereBetween('date', [$startOfMonth, $endOfMonth])
			->pluck('date')
			->map(fn ($d) => Carbon::parse($d)->format('Y-m-d'))
			->toArray();
		
		// Data lainnya
		$streak = $this->calculateHabitStreak($user);
		$checkInsThisWeek = $user->checkIns()
			->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
			->count();
		$dailyMotivation = "Stay consistent and keep pushing forward!";
		
		return view('home', compact('checkInDates', 'streak', 'checkInsThisWeek', 'dailyMotivation', 'habits', 'checkIns', 'goals'));
	}
	
	private function calculateHabitStreak($user)
	{
		$streak = 0;
		
		// Group check-ins by date (without time)
		$checkIns = $user->checkIns()
			->orderBy('date', 'desc')
			->get()
			->groupBy(function ($checkIn) {
				return Carbon::make($checkIn->date)->toDateString(); // Group by date
			});
		
		$dates = $checkIns->keys(); // Get unique dates
		
		foreach ($dates as $index => $date) {
			$currentDate = Carbon::make($date); // Convert to Carbon instance
			if ($index === 0 || $currentDate->diffInDays(Carbon::make($dates[$index - 1])) === 1) {
				$streak++;
			} else {
				break;
			}
		}
		
		return $streak;
	}
	
	public function streak()
	{
		$user = Auth::user();
		$today = now();
		$startOfMonth = $today->copy()->startOfMonth();
		$endOfMonth = $today->copy()->endOfMonth();
		$startDay = $startOfMonth->copy()->startOfWeek();
		$endDay = $endOfMonth->copy()->endOfWeek();
		
		$checkInDates = $user->checkIns()
			->whereBetween('date', [$startOfMonth, $endOfMonth])
			->pluck('date')
			->map(fn ($d) => Carbon::parse($d)->format('Y-m-d'))
			->toArray();
		
		return view('streak', compact('checkInDates', 'startDay', 'endDay'));
	}
}
