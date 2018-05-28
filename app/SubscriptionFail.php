<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionFail extends Model
{
    protected $fillable = ['subscription_id', 'should_start_at', 'should_end_at', 'charge_attempted', 'date_charge_attempted'];
    protected $table = 'subscriptions_failures';

    public function subscription()
    {
    	return $this->belongsTo('App\Subscription', 'subscription_id');
    }
}
