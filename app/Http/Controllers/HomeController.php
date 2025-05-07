<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Habit;
use App\Models\HabitLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
	
	public function streak(Request $request)
	{
		$user = Auth::user();
		
		$month = $request->input('month', now()->month);
		$year = $request->input('year', now()->year);
		
		$currentDate = Carbon::create($year, $month, 1);
		$startOfMonth = $currentDate->copy()->startOfMonth();
		$endOfMonth = $currentDate->copy()->endOfMonth();
		$startDay = $startOfMonth->copy()->startOfWeek();
		$endDay = $endOfMonth->copy()->endOfWeek();
		
		// Get all user goals and habits
		$goalIds = Goal::where('user_id', $user->id)->pluck('id');
		$habitIds = Habit::whereIn('goal_id', $goalIds)->pluck('id');
		$totalHabits = $habitIds->count();
		
		// Get logs from the beginning of the week to today
		$logs = HabitLog::whereIn('habit_id', $habitIds)
			->whereBetween('date', [$startDay->toDateString(), now()->toDateString()])
			->get()
			->groupBy('date');
		
		$completedDates = [];
		$progressByDate = [];
		$progressData = [];
		
		// Calculate completion for each date
		foreach ($logs as $date => $logList) {
			$completedCount = $logList->unique('habit_id')->count();
			$progress = $totalHabits > 0 ? ($completedCount / $totalHabits) * 100 : 0;
			$progressByDate[$date] = round($progress);
			$progressData[$date] = [
				'completed' => $progress,
				'total' => $totalHabits
			];
			
			if ($completedCount === $totalHabits) {
				$completedDates[] = $date;
			}
		}
		
		// Calculate streak - NEW IMPROVED LOGIC
		$streak = 0;
		$date = now()->copy()->subDay(); // Start checking from yesterday
		
		// Sort dates in descending order (newest first)
		usort($completedDates, function($a, $b) {
			return strtotime($b) - strtotime($a);
		});
		
		// Calculate consecutive days from most recent backwards
		while (in_array($date->format('Y-m-d'), $completedDates)) {
			$streak++;
			$date->subDay();
		}
		
		// If today is also completed, add 1 to streak
		if (in_array(now()->format('Y-m-d'), $completedDates)) {
			$streak++;
		}
		
		return view('streak', [
			'checkInDates' => $completedDates,
			'progressByDate' => $progressByDate,
			'progressData' => $progressData,
			'startDay' => $startDay,
			'endDay' => $endDay,
			'currentDate' => $currentDate,
			'streak' => $streak,
		]);
	}
}
