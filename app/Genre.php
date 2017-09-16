<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';

    public function games()
    {
    	return $this->belongsToMany('App\Game', 'link_games_genres', 'genre_id', 'game_id');
    }
}
