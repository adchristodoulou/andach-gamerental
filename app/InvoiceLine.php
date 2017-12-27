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
        return '<tr>
            <td class="col-1">'.$this->quantity_invoiced.'x</td>
            <td class="col-7"><a href="'.route('product.show', $this->product->slug).'">'.$this->product->name.'</a></td>
            <td class="col-2 text-right">'.$this->getFormattedValue('net').'</td>
            <td class="col-2 text-right">'.$this->getFormattedValue('gross').'</td>
        </tr>';
    }

    public function getFormattedValue($name)
    {
        return '&pound;'.number_format($this->$name / 100, 2);
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
