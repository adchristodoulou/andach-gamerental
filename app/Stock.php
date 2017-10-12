<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['game_id', 'date_purchased', 'purchase_price', 'currently_in_stock'];
    protected $table = 'stock';

    public function assignments()
    {
        return $this->hasMany('App\Assignment', 'stock_id');
    }

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }

    public function getPurchasePriceFormattedAttribute()
    {
        return '&pound;'.number_format($this->purchase_price / 100, 2);
    }

    public function retire($reasonID)
    {
        if ($this->date_retired) return;
        $this->date_retired = today();
        $this->retired_reason_id = $reasonID;
        $this->save();

        $this->game->incrementStock(-1);
    }

    public function retirementReason()
    {
    	return $this->belongsTo('App\RetirementReason', 'retired_reason_id');
    }
}
