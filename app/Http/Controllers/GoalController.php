<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
	public function store(Request $request)
	{
		$request->validate([
			'title' => 'required|string|max:255',
			'description' => 'nullable|string',
			'target' => 'nullable|string',
			'target_date' => 'nullable|date',
		]);
		
		Goal::create([
			'user_id' => Auth::id(),
			'title' => $request->title,
			'description' => $request->description,
			'target' => $request->target,
			'target_date' => $request->target_date,
		]);
		
		return redirect()->route('dashboard');
	}
}
