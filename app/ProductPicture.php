<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class ProductPicture extends Model
{
	protected $fillable = ['product_id', 'url', 'thumb_url', 'is_main'];
    protected $table = 'products_pictures';

    public function deleteImages()
    {
    	Storage::delete('public/'.$this->url);
    	Storage::delete('public/'.$this->thumb_url);
    }

    public function getFullPathAttribute()
    {
    	return '/storage/'.$this->url;
    }

    public function getHeightAttribute()
    {
        $imageDetails = getimagesize($_SERVER['DOCUMENT_ROOT'].'/storage/'.$this->url);

        return $imageDetails[1];
    }

    public function getThumbPathAttribute()
    {
    	return '/storage/'.$this->thumb_url;
    }

    public function getWidthAttribute()
    {
        $imageDetails = getimagesize($_SERVER['DOCUMENT_ROOT'].'/storage/'.$this->url);

        return $imageDetails[0];
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
