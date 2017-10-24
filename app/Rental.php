<?php

namespace App;

use App\Mail\GameDelivered;
use Illuminate\Database\Eloquent\Model;
use Mail;
class Rental extends Model
{
    protected $table = 'rentals';

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }

    public function markAsPosted()
    {
        $this->date_of_delivery = date('Y-m-d');
        $this->save();

        $this->stock->times_rented = $this->game->times_rented + 1;
        $this->stock->save();

        Mail::to($this->user)->send(new GameDelivered($this));
    }

    public function stock()
    {
    	return $this->belongsTo('App\Stock', 'stock_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
