<?php

namespace App\Http\Controllers;

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
}
