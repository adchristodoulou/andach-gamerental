<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitorPrice extends Model
{
	protected $fillable = ['listing_id', 'price_new', 'price_preown'];
    protected $table = 'competitors_prices';

    public function listing()
    {
    	return $this->belongsTo('App\CompetitorListing', 'listing_id');
    }
}
