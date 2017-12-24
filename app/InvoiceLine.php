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

    public function invoice()
    {
    	return $this->belongsTo('App\Invoice', 'invoice_id');
    }

    public function product()
    {
    	return $this->belongsTo('App\Product', 'product_id');
    }
}
