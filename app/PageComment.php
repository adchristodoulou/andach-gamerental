<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageComment extends Model
{
    protected $fillable = ['user_id', 'comment', 'page_id'];
    protected $table = 'pages_comments';
    
    public function getBoxAttribute()
    {
        return '<div class="card">
            <div class="card-header">'.e($this->user->name).'</div>
            <div class="card-body">'.e($this->comment).'</div>
            <div class="card-footer">'.e($this->created_at).'</div>
            </div>';
    }
    
    public function page()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
