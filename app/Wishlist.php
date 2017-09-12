<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
	protected $table = 'wishlist';

	public function game()
	{
		return $this->belongsTo('App\Game', 'game_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
