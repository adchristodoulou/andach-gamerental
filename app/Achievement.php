<?php

namespace App;

use App\AchievementEarned;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
	protected $fillable = ['name', 'third_party_id', 'game_id', 'system_id', 'gamerscore', 'achievement_description', 'achievement_locked_description', 'trophy', 'trophy_description', 'trophy_locked_description', 'is_secret', 'is_rare', 'percentage_unlocked', 'image'];
    protected $table = 'achievements';

    public function earned()
    {
    	return $this->hasMany('App\AchievementEarned', 'achievement_id');
    }

    //Retrns the earned() row for the given userID. 
    public function earnedBy($userID)
    {
        return $this->hasMany('App\AchievementEarned', 'achievement_id')->where('user_id', '=', $userID);
    }

    public function earnedByLoggedOnUser()
    {
        return $this->earnedBy(Auth::id());
    }

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }

    public function getEarnedDateAttribute($userID = '')
    {
        if (!$userID) $userID = Auth::id();
        if ($earning = $this->earnedBy($userID)->first())
        {
            return $earning->date_of_earning;
        }
        return 0;
    }

    public function requirements()
    {
    	return $this->hasMany('App\AchievementRequirements', 'achivement_id');
    }

    public function setEarned($date, $userID)
    {
    	if (strtotime($date) < strtotime('2000-01-01'))
    	{
    		return null;
    	}

    	$where['achievement_id'] = $this->id;
    	$where['game_id'] = $this->game_id;
    	$where['user_id'] = $userID;
    	$where['date_of_earning'] = $date;

    	$earned = AchievementEarned::firstOrCreate($where);
    }

    public function system()
    {
    	return $this->belongsTo('App\System', 'system_id');
    }

    //Updates the achievements underlying requirements with the line being a single item in an array passed from IGAD::getAchievements()
    public function updateRequirements($line)
    {
    	foreach ($line['requirements'] as $req)
    	{
    		$where['achievement_id'] = $this->id;
    		$where['microsoft_guid'] = $req['microsoft_guid'];
    		$where['operation_type'] = $req['operation_type'];
    		$where['value_type'] = $req['value_type'];
    		$where['target'] = $req['target'];
    		$where['rule_participation_type'] = $req['rule_participation_type'];

    		$requirement = AchievementRequirement::firstOrCreate($where);
    	}
    }

    //Updates the user's progress with the line being a single item in an array passed from IGAD::getAchievements()
    public function updateUserProgress($line, $userID = null)
    {
    	if (!$userID)
    	{
    		$userID = Auth::id();
    	}

    	if ($line['date_of_earning'])
    	{
    		$this->setEarned($line['date_of_earning'], $userID);
    	}

    	foreach ($line['requirements'] as $req)
    	{
    		if ($req['value'])
    		{
    			$id = AchievementRequirement::where('microsoft_guid', $req['microsoft_guid'])->first()->pluck('id');
	    		$id = $id[0];

	    		$where['requirement_id'] = $id;
	    		$where['user_id'] = $userID;
	    		$reqModel = AchievementRequirementProgress::firstOrNew($where);
	    		$reqModel->value = $req['value'];
	    		$reqModel->save();
    		}
    	}
    }
}
