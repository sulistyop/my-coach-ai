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
		
		// Step 1: Ambil semua goals user
		$goalIds = Goal::where('user_id', $user->id)
			->pluck('id');
		
		// Step 2: Ambil semua habits yang terkait dengan goals tersebut
		$habitIds = Habit::whereIn('goal_id', $goalIds)
			->pluck('id');
		
		// Hitung total habit yang dimiliki oleh user
		$totalHabits = $habitIds->count();
		
		// Step 3: Ambil semua HabitLog dalam rentang tanggal mulai bulan hingga hari ini
		$logs = HabitLog::whereIn('habit_id', $habitIds)
			->whereBetween('date', [$startDay->toDateString(), now()->toDateString()])
			->get()
			->groupBy('date');
		
		$completedDates = [];
		$progressByDate = [];
		$progressData = []; // Menambahkan progress data per tanggal
		
		// Iterasi untuk menghitung progress per tanggal
		foreach ($logs as $date => $logList) {
			// Hitung habit unik yang tercatat pada tanggal tersebut
			$completedCount = $logList->unique('habit_id')->count();
			$progress = $totalHabits > 0 ? ($completedCount / $totalHabits) * 100 : 0;
			$progressByDate[$date] = round($progress); // Progres dalam persen
			$progressData[$date] = $progress; // Simpan progres untuk digunakan di view
			
			// Jika semua habit diselesaikan pada tanggal tersebut
			if ($completedCount === $totalHabits) {
				$completedDates[] = $date;
			}
		}
		
		
		// Step 4: Hitung streak mundur dari hari ini
		$streak = 0;
		$date = now()->copy();
		while (in_array($date->format('Y-m-d'), $completedDates)) {
			$streak++;
			$date->subDay();
		}
		
		// Mengirimkan data ke view
		return view('streak', [
			'checkInDates' => $completedDates,
			'progressByDate' => $progressByDate,
			'progressData' => $progressData, // Menambahkan progressData
			'startDay' => $startDay,
			'endDay' => $endDay,
			'currentDate' => $currentDate,
			'streak' => $streak,
		]);
	}
}
