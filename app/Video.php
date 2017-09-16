<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
	protected $fillable = ['name', 'youtube_id'];
    protected $table = 'videos';

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }
}
