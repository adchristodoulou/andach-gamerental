<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AchievementEarned extends Model
{
    protected $fillable = ['achievement_id', 'game_id', 'date_of_earning', 'user_id'];
    protected $table = 'achievements_earned';

    public function achievement()
    {
    	return $this->belongsTo('App\Achievement', 'achievement_id');
    }

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
