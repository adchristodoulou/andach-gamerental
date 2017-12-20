<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryNoteLine extends Model
{
    protected $table = 'deliverynotes_lines';

    public function deliveryNote()
    {
    	return $this->belongsTo('App\DeliveryNote', 'deliverynote_id');
    }

    public function invoiceLine()
    {
    	return $this->belongsTo('App\InvoiceLine', 'invoice_line_id');
    }
}
