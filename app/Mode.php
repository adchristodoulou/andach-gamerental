<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    public function games() 
    {
    	return $this->belongsToMany('App\Game', 'link_games_modes', 'mode_id', 'game_id');
    }
}
