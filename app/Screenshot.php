<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    protected $table = 'screenshots';

    public game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }
}
