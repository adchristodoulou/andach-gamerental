<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionCharge extends Model
{
    protected $fillable = ['subscription_id', 'starts_at', 'ends_at', 'charge', 'date_charge_taken'];
    protected $table = 'subscriptions_charges';

    public function scopeCurrent($query)
    {
    	return $query->where('starts_at', '<=', date('Y-m-d'))
            ->where(function ($query) {
                $query->whereNull('ends_at')->
                	orWhere('ends_at', '>=', date('Y-m-d'));
            });
    }

    public function subscription()
    {
    	return $this->belongsTo('App\Subscription', 'subscription_id');
    }
}
