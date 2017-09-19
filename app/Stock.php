<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['game_id', 'stock_movement', 'note'];
    protected $table = 'stock';

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }
}
