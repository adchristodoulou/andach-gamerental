<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentRun extends Model
{
    protected $table = 'assignment_runs';

    public function assign($stock, $user)
    {
    	$create['run_id'] = $this->id;
    	$create['user_id'] = $user->id;
    	$create['stock_id'] = $stock->id;
    	$create['game_id'] = $stock->game->id;

    	return Assignment::create($create);
    }

    public function assignments()
    {
    	return $this->hasMany('App\Assignment', 'run_id');
    }

    public function makeAssignments()
    {
        foreach (array(1, 0) as $priority)
        {
            //Firstly take all the users with priority subscriptions. 
            $plans = Plan::where('is_priority', $priority)->pluck('braintree_plan');
            $subscriptions = Subscription::whereIn('braintree_plan', $plans)->pluck('user_id');
            $users = User::whereIn('id', $subscriptions)->with(['wishlistGames.stock' => function ($query) {
                    $query->where('currently_in_stock', 1);
                }])->get();

            $numAssignments = 0;
            $assignToUser = true;
            
            foreach ($users as $user)
            {
                if ($user->num_games_on_rental < $user->currentMaxGames())

                $assignToUser = true;
                foreach ($user->wishlistGames as $game)
                {
                    foreach ($game->stock as $stock)
                    {
                        if ($assignToUser)
                        {
                            if ($this->assign($stock, $user))
                            {
                                $numAssignments++;
                                $assignToUser = false;
                            }
                        }
                    }
                }
            }
        }
    	

    	return $numAssignments;
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
