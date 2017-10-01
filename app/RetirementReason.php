<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetirementReason extends Model
{
    protected $table = 'retirement_reasons';

    public function stock()
    {
    	return $this->hasMany('App\Stock', 'retired_reason_id');
    }
}
