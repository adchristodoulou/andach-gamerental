<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    protected $fillable = ['invoice_id', 'product_id', 'quantity_invoiced', 'net', 'vat', 'gross', 'net_per_item', 'vat_per_item', 'gross_per_item'];
    protected $table = 'invoices_lines';

    public function deliveryNoteLines()
    {
    	return $this->hasMany('App\DeliveryNoteLine', 'invoice_line_id');
    }

    public function getBoxAttribute()
    {
        return '<div class="row">
            <div class="col-1">'.$this->quantity_invoiced.'x</div>
            <div class="col-7"><a href="'.route('product.show', $this->product->slug).'">'.$this->product->name.'</a></div>
            <div class="col-2">'.$this->net.'</div>
            <div class="col-2">'.$this->gross.'</div>
        </div>';
    }

    public function invoice()
    {
    	return $this->belongsTo('App\Invoice', 'invoice_id');
    }

    public function product()
    {
    	return $this->belongsTo('App\Product', 'product_id');
    }
}
