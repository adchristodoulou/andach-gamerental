<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    protected $table = 'contacts_replies';

    public function contact()
    {
    	return $this->belongsTo('App\Contact', 'contact_id');
    }

    public function getBoxAttribute()
    {
    	return '<div class="card">
    		<div class="card-header">Reply on '.e($this->created_at).' by '.e($this->user->name).'</div>
    		<div class="card-body">'.nl2br(e($this->full_text)).'</div>
    	</div>';
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
