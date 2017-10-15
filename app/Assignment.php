<?php

namespace App;
use App\Rental;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['run_id', 'user_id', 'game_id', 'stock_id'];
    protected $table = 'assignments';

    public function assignmentRun()
    {
    	return $this->belongsTo('App\AssignmentRun', 'run_id');
    }

    public function confirm()
    {
        dd('need to write this');
    }

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }

    public function makeIntoRental()
    {
        $stock = Stock::find($this->stock_id);
        if ($stock->currently_in_stock < 1) return false;
        $stock->currently_in_stock = $stock->currently_in_stock - 1;
        $stock->save();


        $rental = new Rental;
        $rental->user_id  = $this->user_id;
        $rental->game_id  = $this->game_id;
        $rental->stock_id = $this->stock_id;
        $rental->date_of_assignment = date('Y-m-d', strtotime($this->created_at));
        $rental->save();

        $this->rental_id = $rental->id;
        $this->save();

        //Finally remove it from the wishlist
        $wishlistRows = Wishlist::where('user_id', $this->user_id)->where('game_id', $this->game_id)->delete();

        return true;
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
