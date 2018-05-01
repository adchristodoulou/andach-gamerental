<?php

namespace App;

use App\Mail\ContactUpdate;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Mail;

class Contact extends Model
{
	protected $fillable = ['user_id', 'email', 'phone', 'category_id', 'title', 'full_text', 'closed_at'];
    protected $table = 'contacts';

    //Takes a posted file object as $request->file and uploads it. 
    public function addAttachment($file)
    {
        if (!$file) return false;
        $path = $file->store('contacts');

        $attachment = new ContactAttachment;
        $attachment->contact_id = $this->id;
        $attachment->filename   = $file->getClientOriginalName();
        $attachment->url        = $path;
        $attachment->slug       = pathinfo($path, PATHINFO_FILENAME);
        $attachment->extension  = pathinfo($path, PATHINFO_EXTENSION);
        $attachment->user_id    = Auth::id();
        $attachment->save();
    }

    public function attachments()
    {
    	return $this->hasMany('App\ContactAttachment', 'contact_id');
    }

    public function category()
    {
    	return $this->belongsTo('App\ContactCategory', 'category_id');
    }

    public function close()
    {
        $this->closed_at = date('Y-m-d h:i:s');
        $this->closed_by = Auth::id();
        $this->save();
    }

    public function closeUser()
    {
        return $this->belongsTo('App\User', 'closed_by');
    }

    public function getBoxAttribute()
    {
        if ($this->isClosed())
        {
            $closedText = 'CLOSED - ';
        } else {
            $closedText = '';
        }

        return '<div class="card">
            <div class="card-header"><a href="'.route('contact.show', $this->id).'"">#'.$this->id.' '.$closedText.$this->title.'</a></div>
            <div class="card-body">'.$this->full_text.'</div>
            <div class="card-footer">'.$this->created_at.'</div>
        </div>';
    }

    public function getClosedByNameAttribute()
    {
        if ($this->closeUser)
        {
            return $this->closeUser->name;
        }
    }

    public function getOrderedBoxes()
    {
        $attachments = $this->attachments;
        $replies     = $this->replies;

        $return = array();

        foreach ($this->attachments as $a)
        {
            $return[$a->created_at->timestamp.'a'] = $a->box;
        }

        foreach ($this->replies as $r)
        {
            $return[$r->created_at->timestamp.'b'] = $r->box;
        }
        ksort($return);

        return $return;
    }

    public function getUserNameAttribute()
    {
        if ($this->user)
        {
            return $this->user->name;
        }

        return $this->email;
    }

    public function isClosed()
    {
        return $this->closed_by > 0;
    }

    public function replies()
    {
    	return $this->hasMany('App\ContactReply', 'contact_id');
    }

    public function sendEmailUpdate()
    {
        if ($this->email)
        {
            $to = $this->email;
        } else {
            $to = $this->user;
        }

        Mail::to($to)->send(new ContactUpdate($this));
        Mail::to('andreas@andachgames.co.uk')->send(new ContactUpdate($this));
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
