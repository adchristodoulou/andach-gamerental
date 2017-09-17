<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    protected $table = 'franchises';

    public function games()
    {
    	return $this->hasMany('App\Game', 'franchise_id');
    }
}
