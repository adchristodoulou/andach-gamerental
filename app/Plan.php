<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
	protected $fillable = ['name', 'slug', 'braintree_plan', 'cost', 'description', 'max_games_simultaneously', 'is_premium', 'is_priority', 'max_games_per_month'];
    protected $table = 'plans';

    public function getMaxGamesPerMonthFormattedAttribute()
    {
    	if ($this->max_games_per_month > 10)
    	{
    		return 'Unlimited';
    	}

    	return $this->max_games_per_month;
    }
}
