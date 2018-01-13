<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
	protected $fillable = ['name', 'slug', 'braintree_plan', 'cost', 'description', 'max_games_simultaneously', 'is_premium', 'is_priority', 'max_games_per_month'];
    protected $table = 'plans';
}
