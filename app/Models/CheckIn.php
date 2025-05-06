<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckIn extends Model
{
	protected $fillable = [
		'user_id',
		'answer',
		'ai_response',
		'mood',
		'date'
	];
	
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
