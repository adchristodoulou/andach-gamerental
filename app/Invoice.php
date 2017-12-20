<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    public function lines()
    {
    	return $this->hasMany('App\InvoiceLine', 'invoice_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
