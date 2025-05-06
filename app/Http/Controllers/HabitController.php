<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{
	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:255',
			'frequency' => 'required|integer',
		]);
		
		Habit::create([
			'user_id' => Auth::id(),
			'name' => $request->name,
			'frequency' => $request->frequency,
		]);
		
		return redirect()->route('dashboard');
	}
}
