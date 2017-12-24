<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Form;
use Request;

class Cart extends Model
{
	protected $fillable = ['product_id', 'user_id', 'ip_address', 'quantity_in_cart'];
    protected $table = 'cart';

    public function addQuantity($quantity)
    {
    	$this->quantity_in_cart = $this->quantity_in_cart + $quantity;
    	$this->save();
    }

    public static function empty()
    {
        if (Auth::check())
        {
            self::where('user_id', Auth::id())->delete();
        }
        self::where('ip_address', Request::ip())->delete();
    }

    public function getBoxAttribute()
    {
    	return '<div class="row">
    		<div class="col-6"><a href="'.route('product.show', $this->product->slug).'">'.$this->product->name.'</a></div>
    		<div class="col-2">'.
    			Form::text('cartQuantity['.$this->id.']', $this->quantity_in_cart, ['class' => 'form-control'])
    		.'</div>
    		<div class="col-2">'.$this->product->price_formatted.'</div>
    		<div class="col-2">'.$this->price_formatted.'</div>
    		</div>';
    }

    public function getBoxMiniAttribute()
    {
    	return '<div class="row">
    		<div class="col-12"><a href="'.route('product.show', $this->product->slug).'">'.$this->product->name.'</a></div>
    		<div class="col-4">'.$this->quantity_in_cart.'</div>
    		<div class="col-8">'.$this->price_formatted.'</div>
    		</div>';
    }

    public function getPriceAttribute()
    {
    	return $this->quantity_in_cart * $this->product->price / 100;
    }

    public function getPriceFormattedAttribute()
    {
    	return '&pound;'.number_format($this->price, 2);
    }

    //Returns the array needed to convert this into an invoice line.
    public function invoiceLineArray()
    {
        $priceArray = $this->product->priceArray();

        $return['product_id'] = $this->product_id;
        $return['quantity_invoiced'] = $this->quantity_in_cart;
        $return['net'] = $this->quantity_in_cart * $priceArray['net'];
        $return['vat'] = $this->quantity_in_cart * $priceArray['vat'];
        $return['gross'] = $this->quantity_in_cart * $priceArray['gross'];
        $return['net_per_item'] = $priceArray['net'];
        $return['vat_per_item'] = $priceArray['vat'];
        $return['gross_per_item'] = $priceArray['gross'];
        
        return $return;
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

    public static function priceFromLines($lines = null)
    {
    	if (!$lines)
    	{
    		$lines = self::myCart();
    	}

    	$return['lines'] = 0;
		foreach ($lines as $line)
		{
			$return['lines'] += $line->price;
		}
		
		if ($return['lines']  >= 20)
		{
			$return['shipping']  = 0.00;
		} else {
			$return['shipping']  = 1.99;
		}

		$return['total'] = $return['lines'] + $return['shipping'];

		return $return;
    }

    public function product()
    {
    	return $this->belongsTo('App\Product', 'product_id');
    }

    public function setQuantity($quantity)
    {
    	$this->quantity_in_cart = $quantity;
    	$this->save();
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
