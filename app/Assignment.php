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

    public function deliver()
    {
        $this->rental->markAsPosted();
    }

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }

    public function makeIntoRental()
    {
        $rental = new Rental;
        $rental->user_id  = $this->user_id;
        $rental->game_id  = $this->game_id;
        $rental->stock_id = $this->stock_id;
        $rental->date_of_assignment = date('Y-m-d', strtotime($this->created_at));
        $rental->save();

        $this->rental_id = $rental->id;
        $this->save();

        return true;
    }

    public function rental()
    {
        return $this->belongsTo('App\Rental', 'rental_id');
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
