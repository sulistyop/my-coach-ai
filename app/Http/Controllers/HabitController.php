<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitController extends Controller
{
	public function index()
	{
		$habits = Habit::where('user_id', Auth::id())
			->orderBy('created_at', 'desc')
			->get();
		return view('habit.index', compact('habits'));
	}
	
	public function create()
	{
		return view('setup.habits');
	}
	
	
	public function markDone(Habit $habit)
	{
		$today = now()->toDateString();
		$habit->update(['last_completed_at' => $today]);
		
		$logExists = $habit->logs()->where('date', $today)->exists();
		
		if (!$logExists) {
			$habit->logs()->create([
				'habit_id' => $habit->id,
				'date' => $today,
				'completed' => true,
				'notes' => null,
			]);
		}
		
		return redirect()->route('habits')->with('success', 'Habit marked as done!');
	}
	
	public function history()
	{
		$userId = Auth::id();
		
		$startOfWeek = now()->startOfWeek(); // Senin
		$endOfWeek = now()->endOfWeek();     // Minggu
		
		$habits = Habit::with(['logs' => function ($query) use ($startOfWeek, $endOfWeek) {
			$query->whereBetween('date', [$startOfWeek, $endOfWeek]);
		}])->where('user_id', $userId)->get();
		
		$checkIns = CheckIn::where('user_id', $userId)
			->whereBetween('created_at', [$startOfWeek, $endOfWeek])
			->latest()
			->get();
		
		$weeklyProgress = $habits->map(function ($habit) use ($startOfWeek) {
			$logs = $habit->logs->keyBy('date'); // indexed by date
			$dailyStatuses = [];
			
			for ($i = 0; $i < 7; $i++) {
				$date = $startOfWeek->copy()->addDays($i)->toDateString();
				$log = $logs->get($date);
				
				$dailyStatuses[] = [
					'date' => $date,
					'completed' => $log ? $log->completed : null, // null = belum ada data
				];
			}
			
			return [
				'habit' => $habit,
				'daily' => $dailyStatuses,
			];
		});
		
		return view('history.index', compact('weeklyProgress', 'checkIns'));
	}
}
