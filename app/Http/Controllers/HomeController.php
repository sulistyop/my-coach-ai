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
		
		// Check if the user has any goals
		$goals = $user->goals()->first();
		
		if (!$goals) {
			return redirect()->route('create-goals')->with('message', 'Please create a goal to get started.');
		}
		
		$today = now();
		$startOfMonth = $today->copy()->startOfMonth();
		$endOfMonth = $today->copy()->endOfMonth();
		$habits = $user->habits;
		
		// Get all user goals and habits
		$goalIds = Goal::where('user_id', $user->id)->pluck('id');
		$habitIds = Habit::whereIn('goal_id', $goalIds)->pluck('id');
		$totalHabits = $habitIds->count();
		
		// Get logs from the beginning of the week to today
		$logs = HabitLog::whereIn('habit_id', $habitIds)
			->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
			->get()
			->groupBy('date');
		
		$completedDates = [];
		
		// Calculate completion for each date
		foreach ($logs as $date => $logList) {
			$completedCount = $logList->unique('habit_id')->count();
			if ($completedCount === $totalHabits) {
				$completedDates[] = $date;
			}
		}
		
		// Calculate streak
		$streak = 0;
		$date = now()->copy()->subDay(); // Start checking from yesterday
		
		// Sort dates in descending order (newest first)
		usort($completedDates, function ($a, $b) {
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
		
		$checkInsThisWeek = HabitLog::whereIn('habit_id', $habitIds)
			->whereBetween('date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])
			->get()
			->unique('habit_id')
			->count();
		
		
		$dailyMotivation = $streak > 0 ? 'Kerja bagus sudah check-in hari ini!' : 'Jangan lupa untuk check-in dan tetap pada jalur!';
		
		return view('home', compact('streak', 'checkInsThisWeek', 'dailyMotivation', 'habits', 'goals'));
	}
	
	public function streak(Request $request)
	{
		Carbon::setLocale('id');
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
