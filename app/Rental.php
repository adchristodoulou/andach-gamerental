<?php

namespace App;

use App\Mail\GameDelivered;
use App\Mail\GameReceived;
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

        $this->user->recordGamePosted();
        Mail::to($this->user)->send(new GameDelivered($this));
    }

    public function markAsReceived($returnedOK = 1)
    {
        if (!$returnedOK) $returnedOK = 0;
        $datediff = time() - strtotime($this->date_of_rental);

        $this->date_of_return = date('Y-m-d');
        $this->returned_ok = $returnedOK;
        $this->length_of_rental = floor($datediff / (60 * 60 * 24));
        $this->save();

        $this->stock->recordReturned();

        $this->user->recordGameReturned();

        Mail::to($this->user)->send(new GameReceived($this));
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
