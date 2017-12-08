<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactAttachment extends Model
{
    protected $table = 'contacts_attachments';

    public function contact()
    {
    	return $this->belongsTo('App\Contact', 'contact_id');
    }

    public function getBoxAttribute()
    {
    	return '<div class="card border-info">
    		<div class="card-header text-info">Attachment added on '.e($this->created_at).' by '.e($this->user->name).'</div>
    		<div class="card-body text-info"><a href="'.route('contact.attachment', $this->slug).'">View this attachment</a></div>
    		<div class="card-footer text-info">Original Name: '.e($this->filename).'</div>
    	</div>';
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
