<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';

    public function games()
    {
    	return $this->hasMany('App\Game', 'collection_id');
    }
}
