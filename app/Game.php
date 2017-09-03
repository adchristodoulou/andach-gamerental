<?php

namespace App;

use App\System;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';

    public system()
    {
    	return $this->belongsTo('App\System', 'system_id');
    }
}
