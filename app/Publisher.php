<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'companies';

    public function games()
    {
    	return $this->hasMany('App\Game', 'publisher_id');
    }
}
