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

    //For use when a user logs in to convert any lines they might have in their cart and add them to any lines they have against their user. 
    public static function convertCartToUser()
    {
        if (!Auth::check()) return false;

        $cartLinesIP   = Cart::where('ip_address', Request::ip())->get();
        $cartLinesUser = Cart::where('user_id', Auth::id())->get();

        foreach ($cartLinesUser as $line)
        {
            if ($ipLine = $cartLinesIP->where('product_id', $line->product_id)->first())
            {
                $line->quantity_in_cart = $line->quantity_in_cart + $ipLine->quantity_in_cart;
                $line->save();
                $ipLine->delete();
            }
        }

        Cart::where('ip_address', Request::ip())->update(['user_id' => Auth::id(), 'ip_address' => '']);
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
    		<div class="col-12 col-md-7"><a href="'.route('product.show', $this->product->slug).'">'.$this->product->name.'</a></div>
    		<div class="col-4 col-md-2">'.$this->quantity_in_cart.'</div>
    		<div class="col-8 col-md-3">'.$this->price_formatted.'</div>
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

        $return['lines'] = number_format($return['lines'], 2);
        $return['shipping'] = number_format($return['shipping'], 2);
        $return['total'] = number_format($return['total'], 2);

		return $return;
    }

    public function product()
    {
    	return $this->belongsTo('App\Product', 'product_id');
    }

    public function setQuantity($quantity)
    {
        if ($quantity == 0)
        {
            $this->delete();
            return false;
        }

    	$this->quantity_in_cart = $quantity;
    	$this->save();
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
