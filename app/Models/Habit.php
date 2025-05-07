<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habit extends Model
{
	protected $fillable = [
		'user_id',
		'goal_id',
		'name',
		'strategy',
		'frequency',
		'best_time',
		'motivation',
		'current_streak',
		'longest_streak',
		'last_completed_at'
	];
	
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
	
	public function logs(): HasMany
	{
		return $this->hasMany(HabitLog::class);
	}

	public function goal(): BelongsTo
	{
		return $this->belongsTo(Goal::class);
	}
}
