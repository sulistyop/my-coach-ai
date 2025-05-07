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
	
	public function streak(Request $request)
	{
		$user = Auth::user();
		
		// Ambil bulan dan tahun dari query string, default ke bulan sekarang
		$month = $request->input('month', now()->month);
		$year = $request->input('year', now()->year);
		
		// Buat objek tanggal berdasarkan bulan dan tahun
		$currentDate = Carbon::create($year, $month, 1);
		$startOfMonth = $currentDate->copy()->startOfMonth();
		$endOfMonth = $currentDate->copy()->endOfMonth();
		$startDay = $startOfMonth->copy()->startOfWeek();
		$endDay = $endOfMonth->copy()->endOfWeek();
		
		// Ambil semua tanggal check-in hingga hari ini (untuk menghitung streak berurutan)
		$allCheckIns = $user->checkIns()
			->where('date', '<=', now()->toDateString())
			->orderBy('date')
			->pluck('date')
			->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
			->toArray();
		
		// Ambil tanggal check-in khusus bulan yang dipilih
		$checkInDates = array_filter($allCheckIns, function ($date) use ($startOfMonth, $endOfMonth) {
			return Carbon::parse($date)->between($startOfMonth, $endOfMonth);
		});
		
		// Hitung streak (jumlah hari berurutan hingga hari ini)
		$streak = 0;
		$date = now()->copy();
		while (in_array($date->format('Y-m-d'), $allCheckIns)) {
			$streak++;
			$date->subDay();
		}
		
		return view('streak', [
			'checkInDates' => $checkInDates,
			'startDay' => $startDay,
			'endDay' => $endDay,
			'currentDate' => $currentDate,
			'streak' => $streak
		]);
	}
}
