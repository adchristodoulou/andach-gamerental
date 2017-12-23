<?php

namespace App;

use App\ProductPicture;
use Illuminate\Database\Eloquent\Model;
use Image;

class Product extends Model
{
    protected $fillable = ['game_id', 'slug', 'price', 'name', 'snippet', 'full_text', 'is_vatable', 'num_in_stock'];
    protected $table = 'products';

    public function addCategory($categoryID)
    {
        $this->categories()->attach($categoryID);
    }

    public function addPicture($requestPicture)
    {
        $array['product_id'] = $this->id;

        //Store the main image.
        $filename = $requestPicture->store('public/products/main');
        $array['url'] = 'products/main/'.basename($filename);

        //Store the thumbnail.
        $img = Image::make($requestPicture->getRealPath());
        $img->resize(250, 250);
        $thumbfilename = 'public/products/thumbnails/'.basename($filename);
        $thumbpath = storage_path('app/'.$thumbfilename);
        $img->save($thumbpath);
        $array['thumb_url'] = 'products/thumbnails/'.basename($filename);

        ProductPicture::create($array);
    }

    public function carts()
    {
    	return $this->hasMany('App\Cart', 'product_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\ProductCategory', 'products_categories_link', 'product_id', 'category_id');
    } 

    public function deleteCategory($categoryID)
    {
        $this->categories()->detach($categoryID);
    }      

    public function getThumbImgAttribute()
    {
        $thumb = $this->thumbPicture();

        if (!$thumb) return '';

        return '<img src="'.$thumb->thumb_path.'">';
    }

    public function invoiceLines()
    {
    	return $this->hasMany('App\InvoiceLine', 'product_id');
    }

    public function pictures()
    {
    	return $this->hasMany('App\ProductPicture', 'product_id');
    }

    public function thumbPicture()
    {
        return $this->pictures->sortByDesc('is_main')->first();
    }
}
