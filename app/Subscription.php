<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	protected $fillable = ['user_id', 'plan_id', 'starts_at', 'trial_ends_at', 'ends_at', 'next_billing_date'];
    protected $table = 'subscriptions';

    public function addSuccessfulCharge($array)
    {
        return $this->charges()->create($array);
    }

    public function calculateChargeToSwitchTo(Plan $plan)
    {
        return $plan->cost - $this->percentage_of_charge_period_remaining * $this->plan->cost;
    }

    public function cancel($overrideEndDate = null)
    {
        if (!$this->ends_at)
        {
            if ($overrideEndDate)
            {
                $this->ends_at = $overrideEndDate;
            } else {
                $this->ends_at = $this->next_billing_date;
            }
            $this->next_billing_date = NULL;
            $this->save();

            return true;
        }

        return false;
    }

    public function charges()
    {
        return $this->hasMany('App\SubscriptionCharge', 'subscription_id');
    }

    public function currentCharge()
    {
        return $this->charges()->current()->first();
    }

    public function failures()
    {
        return $this->hasMany('App\SubscriptionFail', 'subscription_id');
    }

    public function getDaysInCurrentChargePeriodAttribute()
    {
        $currentCharge = $this->currentCharge();
        if (!$currentCharge)
        {
            return false;
        }

        $date1 = new DateTime($currentCharge->ends_at);
        $date2 = new DateTime($currentCharge->starts_at);
        $interval = $date1->diff($date2);

        return $interval->days;
    }

    public function getDaysRemainingBeforeChargeAttribute()
    {
        $date1 = new DateTime($this->next_billing_date);
        $date2 = new DateTime(now());
        $interval = $date1->diff($date2);

        return $interval->days;
    }

    public function getPercentageOfChargePeriodRemainingAttribute()
    {
        return $this->days_remaining_before_charge / $this->days_in_current_charge_period;
    }

    public function getPercentageOfChargePeriodUsedAttribute()
    {
        return 1 - $this->percentage_of_charge_period_remaining;
    }

    public function plan()
    {
    	return $this->belongsTo('App\Plan', 'plan_id');
    }

    public function resume()
    {
        if (!$this->ends_at)
        {
            //Wasn't cancelled to begin with.
            return true;
        }

        if (strtotime($this->ends_at) < strtotime(now()))
        {
            //It's already over and needs a new subscription. 
            return false;
        }

        $this->next_billing_date = $this->ends_at;
        $this->ends_at = NULL;
        $this->save();

        return true;
    }

    public function scopeCurrent($query)
    {
    	return $query->where('starts_at', '<=', date('Y-m-d'))
            ->where(function ($query) {
                $query->whereNull('ends_at')->
                	orWhere('ends_at', '>=', date('Y-m-d'));
            });
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
