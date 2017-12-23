<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class ProductPicture extends Model
{
	protected $fillable = ['product_id', 'url', 'thumb_url', 'is_main'];
    protected $table = 'products_pictures';

    public function delete()
    {
    	dd('app/public/'.$this->url);
    	Storage::delete('app/public/'.$this->url);
    	Storage::delete('app/public/'.$this->thumb_url);
    	$this->delete();
    }

    public function getFullPathAttribute()
    {
    	return '/storage/'.$this->url;
    }

    public function getThumbPathAttribute()
    {
    	return '/storage/'.$this->thumb_url;
    }

    public function product()
    {
    	return $this->belongsTo('App\Product', 'product_id');
    }

    public function setMain($bool)
    {
    	if ($bool)
    	{
    		$this->is_main = true;
    	} else {
    		$this->is_main = false;
    	}

    	$this->save();
    }
}
