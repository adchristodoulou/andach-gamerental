<?php

namespace App;

use App\Game;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    public function games()
    {
    	return $this->hasMany('App\Game', 'rating_id');
    }
}
