<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = ['slug', 'game_id', 'name', 'h1', 'html_title', 'meta_description', 'body', 'date_published', 'author_id', 'is_commentable'];
    protected $table = 'pages';

    public function author()
    {
    	return $this->belongsTo('App\User', 'author_id');
    }
    
    public function canComment()
    {
        return $this->is_commentable && Auth::check();
    }
    
    public function comments()
    {
        return $this->hasMany('App\PageComment', 'page_id');
    }
    
    public function game()
    {
        return $this->belongsTo('App\Game', 'game_id');
    }

    public function getAuthorNameAttribute()
    {
    	if ($this->author)
    	{
    		return $this->author->name;
    	}

    	return '';
    }

    //Replaces certain elements with bootstrap classes. 
    public function getBootstrappedBodyAttribute()
    {
        $return = $this->body;

        $return = str_replace('<blockquote>', '<blockquote class="blockquote">', $return);
        $return = str_replace('type="button"', 'type="button" class="form-control btn btn-success"', $return);

        return $return;
    }
}
