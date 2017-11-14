<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AchievementRequirement extends Model
{
	protected $fillable = ['achievement_id', 'target', 'microsoft_guid', 'value_type', 'operation_type', 'rule_participation_type'];
    protected $table = 'achievements_requirements';

    public function achievement()
    {
    	return $this->belongsTo('App\Achievement', 'achievement_id');
    }
}
