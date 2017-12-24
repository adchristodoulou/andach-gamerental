<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Request;

class Cart extends Model
{
	protected $fillable = ['product_id', 'user_id', 'ip_address', 'quantity_in_cart'];
    protected $table = 'cart';

    public function addQuantity($quantity = 0)
    {
    	$this->quantity_in_cart = $this->quantity_in_cart + $quantity;
    	$this->save();
    }

    public function getBoxAttribute()
    {
    	return '<div class="row">
    		<div class="col-6"><a href="'.route('product.show', $this->product->slug).'">'.$this->product->name.'</a></div>
    		<div class="col-2">'.$this->quantity_in_cart.'</div>
    		<div class="col-2">'.$this->product->price_formatted.'</div>
    		<div class="col-2">'.$this->price_formatted.'</div>
    		</div>';
    }

    public function getPriceFormattedAttribute()
    {
    	return '&pound;'.number_format($this->quantity_in_cart * $this->product->price / 100, 2);
    }

    public static function myCart()
    {
    	if (Auth::check())
		{
			$cartLines = Cart::where('user_id', Auth::id())->get();
		} else {
			$cartLines = Cart::where('ip_address', Request::ip())->get();
		}

		return $cartLines;
    }

    public static function myCartCount()
    {
    	if (Auth::check())
		{
			$cartLines = Cart::where('user_id', Auth::id())->count();
		} else {
			$cartLines = Cart::where('ip_address', Request::ip())->count();
		}

		return $cartLines;
    }

    public function product()
    {
    	return $this->belongsTo('App\Product', 'product_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
