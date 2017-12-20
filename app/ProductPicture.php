<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    protected $table = 'products_pictures';

    public function product()
    {
    	return $this->belongsTo('App\Product', 'product_id');
    }
}
