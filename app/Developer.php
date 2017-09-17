<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $table = 'companies';

    public function games()
    {
    	return $this->hasMany('App\Game', 'developer_id');
    }
}
