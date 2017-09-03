<?php

namespace App;

use App\Game;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function games()
    {
    	return $this->hasMany('App\Game', 'category_id');
    }
}
