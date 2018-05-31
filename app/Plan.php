<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
	protected $fillable = ['name', 'slug', 'braintree_plan', 'cost', 'description', 'max_games_simultaneously', 'is_premium', 'is_priority', 'max_games_per_month'];
    protected $table = 'plans';

    public function getBoxAttribute()
    {
        return '<div class="row">
                    <div class="col-12">'.e($this->name).'</div>
                </div>
                <div class="row">
                    <div class="col-12">'.e($this->description).'</div>
                </div>
                <div class="row">
                    <div class="col-2">'.e($this->max_games_simultaneously).'</div>
                    <div class="col-10">Simultaneous Games</div>
                </div>
                <div class="row">
                    <div class="col-2">'.e($this->is_premium_yes_no).'</div>
                    <div class="col-10">Premium Games Included</div>
                </div>
                <div class="row">
                    <div class="col-2">'.e($this->is_priority_yes_no).'</div>
                    <div class="col-10">Priority Service</div>
                </div>';
    }

    public function getIsPremiumYesNoAttribute()
    {
        if ($this->is_premium)
        {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    public function getIsPriorityYesNoAttribute()
    {
        if ($this->is_priority)
        {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    public function getMaxGamesPerMonthFormattedAttribute()
    {
    	if ($this->max_games_per_month > 10)
    	{
    		return 'Unlimited';
    	}

    	return $this->max_games_per_month;
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription', 'plan_id');
    }
}
