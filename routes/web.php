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
	return auth()->check() ? redirect()->route('home') : view('on_boarding1');
});

Auth::routes();

/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/

Route::middleware('auth')->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	Route::get('/home', [HomeController::class, 'index'])->name('home');
	Route::get('/goals', [GoalController::class, 'index'])->name('goals');

    Route::get('/create-goals', [GoalController::class, 'createGoal'])->name('create-goals');


	Route::get('/habits', [HabitController::class, 'index'])->name('habits');
	Route::get('/history', [HabitController::class, 'history'])->name('history');
	Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

	Route::post('/auth/setup/process', [SetupController::class, 'process'])->name('auth.setup.process');
	Route::get('/auth/setup/next', [SetupController::class, 'nextStep'])->name('auth.setup.next');
	Route::get('/setup/habits', [SetupController::class, 'setupHabits'])->name('setup.habits');
	Route::get('/setup/goals', [SetupController::class, 'setupGoals'])->name('setup.goals');


    Route::post('/store-goals', [GoalController::class, 'storeGoal'])->name('store-goals');

	Route::post('/setup/habits/store', [SetupController::class, 'storeHabits'])->name('setup.habits.store');
	Route::post('/setup/goals/store', [SetupController::class, 'storeGoals'])->name('setup.goals.store');

	Route::get('/goals/{id}/edit', [GoalController::class, 'edit'])->name('goals.edit');
	Route::put('/goals/{id}', [GoalController::class, 'update'])->name('goals.update');
	Route::get('/goals/{goal}', [GoalController::class, 'show'])->name('goals.show');

	Route::get('/checkin', [CheckinController::class, 'index'])->name('checkin');
	Route::get('/checkin/create', [CheckinController::class, 'create'])->name('checkin.create');
	Route::post('/checkin/submit', [CheckinController::class, 'submit'])->name('checkin.submit');

	Route::get('/streak', [HomeController::class, 'streak'])->name('streak');

	Route::patch('/habits/{habit}/mark-done', [HabitController::class, 'markDone'])->name('habit.markDone');
});
