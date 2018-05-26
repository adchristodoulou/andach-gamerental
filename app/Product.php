<?php

namespace App;

use App\ProductPicture;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Image;
use Request;

class Product extends Model
{
    protected $fillable = ['game_id', 'slug', 'price', 'name', 'snippet', 'full_text', 'is_vatable', 'num_in_stock', 'supplier_url', 'supplier_product_id'];
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

    public function addToCart($quantity = 1)
    {
        if (Auth::check())
        {
            $array['user_id'] = Auth::id();
        }
        $array['ip_address'] = Request::ip();
        $array['product_id'] = $this->id;
        $cartLine = Cart::firstOrCreate($array);

        $cartLine->addQuantity($quantity);
    }

    public function carts()
    {
    	return $this->hasMany('App\Cart', 'product_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\ProductCategory', 'products_categories_link', 'product_id', 'category_id');
    } 

    public function competitorListings()
    {
        return $this->hasMany('App\CompetitorListing', 'product_id');
    }

    public function deleteCategory($categoryID)
    {
        $this->categories()->detach($categoryID);
    }

    public function getBoxAttribute()
    {
        return '<div class="col-3">'.$this->thumb_img.'<br />
            <a href="'.route('product.show', $this->slug).'">'.$this->name.'</a><br />
            '.$this->num_in_stock.' in stock</div>';
    }

    public function getFullTextNl2brAttribute()
    {
        return nl2br(e($this->full_text));
    }

    public function getMainImgAttribute()
    {
        $main = $this->thumbPicture();

        if (!$main) return '';

        return '<img src="'.$main->full_path.'">';
    }

    public function getMainImgPathAttribute()
    {
        $main = $this->thumbPicture();

        if (!$main) return '';

        return $main->full_path;
    }

    public function getPriceFormattedAttribute()
    {
        return '&pound;'.number_format($this->price / 100, 2);
    }

    public function getRestOfThumbsDivAttribute()
    {
        $return = '<div class="row">';

        foreach ($this->pictures as $p)
        {
            if (!($p->is_main))
            {
                $return .= '<div class="col-3"><a data-fancybox="gallery" href="'.$p->full_path.'"><img class="img-fluid" src="'.$p->thumb_path.'" /></a></div>';
            }
        }

        $return .= '</div>';

        return $return;
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

    //Returns the price in pence as integers. 
    public function priceArray()
    {
        $return['gross'] = $this->price;
        $return['vat']   = round(($this->price * $this->is_vatable / 6));
        $return['net']   = round(($return['gross'] - $return['vat']));

        return $return;
    }

    public function setMainPictureAsFirst()
    {
        if (!$this->pictures->first())
        {
            return false;
        }
        $this->pictures->first()->setMain(true);
    }

    public function thumbPicture()
    {
        return $this->pictures->sortByDesc('is_main')->first();
    }
}
