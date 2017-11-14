<?php

namespace App;

use App\Game;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $table = 'systems';

    public function achievements()
    {
    	return $this->hasMany('App\Achievement', 'system_id');
    }

    public function games()
    {
    	return $this->hasMany('App\Game', 'system_id');
    }
}
