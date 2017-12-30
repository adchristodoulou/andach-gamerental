<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = ['slug', 'name', 'h1', 'html_title', 'meta_description', 'body', 'date_published', 'author_id'];
    protected $table = 'pages';

    public function author()
    {
    	return $this->belongsTo('App\User', 'author_id');
    }
}
