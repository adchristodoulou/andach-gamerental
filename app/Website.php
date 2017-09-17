<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
	protected $fillable = ['category_id', 'url'];
    protected $table = 'websites';

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }
}
