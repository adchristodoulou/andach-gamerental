<?php

https://github.com/atayahmet/laravel-nestable

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nestable\NestableTrait;

class ProductCategory extends Model
{
	use NestableTrait;

    protected $table = 'products_categories';

    public function products()
    {
    	return $this->belongsToMany('App\Product', 'products_categories_link', 'category_id', 'product_id');
    }
}
