<?php

namespace App;

use App\Cart;
use App\InvoiceLine;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	protected $fillable = ['user_id', 'name', 'email', 'phone', 'shipping_address1', 'shipping_address2', 'shipping_address3', 'shipping_town', 'shipping_county', 'shipping_postcode', 'billing_address1', 'billing_address2', 'billing_address3', 'billing_town', 'billing_county', 'billing_postcode'];
    protected $table = 'invoices';

    public function finalise()
    {
        if ($this->date_of_finalising) return false;

        if (!$this->date_of_invoice)
        {
            $this->date_of_invoice = date('Y-m-d');
        }

        $this->date_of_finalising = date('Y-m-d');

        $this->save();
    }

    public function importCart()
    {
        $cartLines = Cart::myCart();

        foreach ($cartLines as $cartLine)
        {
            $invoiceLine = InvoiceLine::create($cartLine->invoiceLineArray());
            $invoiceLine->invoice_id = $this->id;
            $invoiceLine->save();
        }
    }

    public function lines()
    {
    	return $this->hasMany('App\InvoiceLine', 'invoice_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
