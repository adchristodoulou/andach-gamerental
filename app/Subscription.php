<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    public function plan()
    {
    	return $this->belongsTo('App\Plan', 'braintree_plan', 'braintree_plan');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
