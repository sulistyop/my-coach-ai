<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\ReflectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\DashboardController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
	
Route::get('/', function () {
	return auth()->check() ? redirect()->route('home') : view('welcome');
});

Auth::routes();

/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/
	
Route::middleware('auth')->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	
	Route::get('/home', [HomeController::class, 'index'])->name('home');
	Route::get('/goals', [GoalController::class, 'index'])->name('goals');
	Route::get('/habits', [HabitController::class, 'index'])->name('habits');
	Route::get('/reflection', [ReflectionController::class, 'index'])->name('reflection');
	Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
	
	Route::post('/auth/setup/process', [SetupController::class, 'process'])->name('auth.setup.process');
	Route::get('/auth/setup/next', [SetupController::class, 'nextStep'])->name('auth.setup.next');
	Route::get('/setup/habits', [SetupController::class, 'setupHabits'])->name('setup.habits');
	Route::get('/setup/goals', [SetupController::class, 'setupGoals'])->name('setup.goals');
	
	
	Route::post('/setup/habits/store', [SetupController::class, 'storeHabits'])->name('setup.habits.store');
	Route::post('/setup/goals/store', [SetupController::class, 'storeGoals'])->name('setup.goals.store');
	
	Route::get('/checkin', [CheckinController::class, 'index'])->name('checkin');
	Route::post('/checkin/submit', [CheckinController::class, 'submit'])->name('checkin.submit');
	
	Route::get('/streak', [HomeController::class, 'streak'])->name('streak');
});