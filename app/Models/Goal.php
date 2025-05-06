<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Goal extends Model
{
	protected $fillable = [
		'user_id',
		'title',
		'description',
		'target',
		'target_date'
	];
	
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
