<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetupController extends Controller
{
	public function process(Request $request)
	{
		$steps = [];
		
		if ($request->has('setup_habits')) {
			$steps[] = 'setup_habits';
		}
		
		if ($request->has('setup_goals')) {
			$steps[] = 'setup_goals';
		}
		
		// Save steps to session
		session(['setup_steps' => $steps, 'current_step' => 0]);
		
		return $this->nextStep($request);
	}
	
	public function nextStep(Request $request)
	{
		$steps = session('setup_steps', []);
		$currentStep = session('current_step', 0);
		
		if ($currentStep < count($steps)) {
			$step = $steps[$currentStep];
			session(['current_step' => $currentStep + 1]);
			
			if ($step === 'setup_habits') {
				return redirect()->route('setup.habits');
			}
			
			if ($step === 'setup_goals') {
				return redirect()->route('setup.goals');
			}
		}
		
		Auth::user()->update([
			'is_first_login' => false,
			'setup_completed' => true,
		]);
		
		return redirect()->route('home');
	}
	
	public function storeHabits(Request $request)
	{
		$request->validate([
			'habit_name' => 'required|string|max:255',
			'frequency' => 'required|string|in:daily,weekly',
			'best_time' => 'nullable|date_format:H:i',
			'motivation' => 'nullable|string|max:255',
			'goal_id' => 'required|exists:goals,id',
		]);
		
		Auth::user()->habits()->create([
			'name' => $request->input('habit_name'),
			'frequency' => $request->input('frequency'),
			'best_time' => $request->input('best_time'),
			'motivation' => $request->input('motivation'),
			'goal_id' => $request->input('goal_id'),
		]);
		
		if($request->input('not_setup', false)) {
			return redirect()->route('habits')->with('success', 'Habit berhasil ditambahkan');
		}
		
		return $this->nextStep($request);
	}
	
	public function storeGoals(Request $request)
	{
		$request->validate([
			'goal_name' => 'required|string|max:255',
			'deadline' => 'required|date',
		]);
		
		Auth::user()->goals()->create([
			'title' => $request->input('goal_name'),
			'target_date' => $request->input('deadline'),
			'description' => $request->input('description'),
		]);
		
		if($request->input('not_setup', false)) {
			return redirect()->route('goals')->with('success', 'Tujuan berhasil ditambahkan');
		}
		
		return $this->nextStep($request);
	}
	
	public function setupHabits()
	{
		$goals = Auth::user()
			->goals()
			->get();
		
		
		return view('setup.habits', [
			'goals' => $goals,
		]);
	}
	
	public function setupGoals()
	{
		return view('setup.goals');
	}
	
}
