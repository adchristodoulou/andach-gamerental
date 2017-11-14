<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AchievementRequirementProgress extends Model
{
	protected $fillable = ['requirement_id', 'user_id', 'value'];
    protected $table = 'achievements_requirements_progress';

    public function requirement()
    {
    	return $this->belongsTo('App\AchievementRequirement', 'requirement_id');
    }
    
    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
