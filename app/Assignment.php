<?php

namespace App;

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

    public function stock()
    {
    	return $this->belongsTo('App\Stock', 'stock_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
