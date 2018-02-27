<?php

namespace App;

use App\Cart;
use App\InvoiceLine;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	protected $fillable = ['user_id', 'name', 'email', 'phone', 'shipping_address1', 'shipping_address2', 'shipping_address3', 'shipping_town', 'shipping_county', 'shipping_postcode', 'billing_address1', 'billing_address2', 'billing_address3', 'billing_town', 'billing_county', 'billing_postcode'];
    protected $table = 'invoices';

    public function calculateTotals()
    {
        $this->lines_net   = $this->lines->sum('net');
        $this->lines_vat   = $this->lines->sum('vat');
        $this->lines_gross = $this->lines->sum('gross');
        $this->net   = $this->lines_net + $this->shipping_net;
        $this->vat   = $this->lines_vat + $this->shipping_vat;
        $this->gross = $this->lines_gross + $this->shipping_gross;
    }

    public function finalise()
    {
        if ($this->date_of_finalising) return false;

        $this->calculateTotals();

        if (!$this->date_of_invoice)
        {
            $this->date_of_invoice = date('Y-m-d');
        }

        $this->date_of_finalising = date('Y-m-d');

        $this->save();
    }

    public function getFormattedBillingAddressAttribute()
    {
        $array[] = $this->billing_address1;
        $array[] = $this->billing_address2;
        $array[] = $this->billing_address3;
        $array[] = $this->billing_town;
        $array[] = $this->billing_county;
        $array[] = $this->billing_postcode;

        return implode('<br />', array_filter($array));
    }

    public function getFormattedShippingAddressAttribute()
    {
        $array[] = $this->shipping_address1;
        $array[] = $this->shipping_address2;
        $array[] = $this->shipping_address3;
        $array[] = $this->shipping_town;
        $array[] = $this->shipping_county;
        $array[] = $this->shipping_postcode;

        return implode('<br />', array_filter($array));
    }

    public function getFormattedUserInfoAttribute()
    {
        $array[] = $this->name;
        $array[] = $this->email;
        $array[] = $this->phone;
        $array[] = $this->date_of_invoice;

        return implode('<br />', array_filter($array));
    }

    public function getFormattedValue($name)
    {
        return '&pound;'.number_format($this->$name / 100, 2);
    }

    public function importCart()
    {
        $cartLines = Cart::myCart();

        foreach ($cartLines as $cartLine)
        {
            $invoiceLine = new InvoiceLine;
            $invoiceLine->fill($cartLine->invoiceLineArray());
            $invoiceLine->invoice_id = $this->id;
            $invoiceLine->save();
        }
    }

    public function lines()
    {
    	return $this->hasMany('App\InvoiceLine', 'invoice_id');
    }

    public function setShippingGrossInPounds($price)
    {
        $this->shipping_gross = round($price * 100);
        $this->shipping_vat   = round($this->shipping_gross / 6);
        $this->shipping_net   = $this->shipping_gross - $this->shipping_vat;
        $this->save();
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
