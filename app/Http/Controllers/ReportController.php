<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\HabitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		$habitLogs = HabitLog::whereHas('habit', fn($q) => $q->where('user_id', $user->id))->get();
		$checkIns = CheckIn::where('user_id', $user->id)->get();
		
		return view('reports.index', compact('habitLogs', 'checkIns'));
	}
}
