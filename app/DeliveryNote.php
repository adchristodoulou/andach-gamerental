<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    protected $table = 'deliverynotes';

    public function lines()
    {
    	return $this->hasMany('App\DeliveryNoteLine', 'deliverynote_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
