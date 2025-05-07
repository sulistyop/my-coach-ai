<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		$goals = $user->goals()->latest()->get();

		return view('goals.index', compact('goals'));
	}

	public function create()
	{
		return view('setup.goals');
	}
	
	public function show(Goal $goal)
	{
		$habits = $goal->habits()->with(['logs' => function ($query) {
			$query->whereDate('created_at', now()->toDateString());
		}])->get();
		
		$habits = $goal->habits()->with('logs')->get();
		$habitsDone = $habits->filter(fn($habit) => $habit->logs->isNotEmpty())->count();
		$habitsTotal = $habits->count();
		
		return view('goals.show',  compact('goal', 'habits', 'habitsDone', 'habitsTotal'));
	}
	
	public function edit($id)
	{
		$goal = Goal::findOrFail($id);
		return view('goals.edit', compact('goal'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'title' => 'required|string|max:255',
			'description' => 'nullable|string',
			'target_date' => 'required|date',
		]);

		$goal = new Goal();
		$goal->title = $request->input('title');
		$goal->description = $request->input('description');
		$goal->target_date = $request->input('target_date');
		$goal->user_id = Auth::id();
		$goal->save();

		return redirect()->route('goals')->with('success', 'Tujuan berhasil ditambahkan');
	}

	public function update(Request $request, Goal $goal)
	{
		$request->validate([
			'title' => 'required|string|max:255',
			'description' => 'nullable|string',
			'target_date' => 'required|date',
		]);

		$goal->title = $request->input('title');
		$goal->description = $request->input('description');
		$goal->target_date = $request->input('target_date');
		$goal->user_id = Auth::id();
		$goal->save();

		return redirect()->route('goals')->with('success', 'Tujuan berhasil diperbarui');
	}

	public function destroy(Goal $goal)
	{
		$goal->delete();

		return redirect()->route('goals.index')->with('success', 'Tujuan berhasil dihapus');
	}
}
