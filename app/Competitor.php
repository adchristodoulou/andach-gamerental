<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    protected $table = 'competitors';

    public function company()
    {
    	return $this->belongsTo('App\Company', 'company_id');
    }

    public function listings()
    {
    	return $this->hasMany('App\CompetitorListing', 'competitor_id');
    }
}
