<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactCategory extends Model
{
    protected $table = 'contacts_categories';

    public function contacts()
    {
    	return $this->hasMany('App\Contact', 'category_id');
    }
}
