<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function carts()
    {
    	return $this->hasMany('App\Cart', 'product_id');
    }

    public function invoiceLines()
    {
    	return $this->hasMany('App\InvoiceLine', 'product_id');
    }

    public function pictures()
    {
    	return $this->hasMany('App\ProductPicture', 'product_id');
    }

    public function products()
    {
    	return $this->belongsToMany('App\ProductCategory', 'products_categories_link', 'product_id', 'category_id');
    }
}
