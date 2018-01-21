<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitorListing extends Model
{
    protected $fillable = ['product_id', 'game_id', 'competitor_id', 'url_new', 'url_preown', 'url_buy', 'url_voucher', 'latest_price_new', 'latest_price_preown'];
    protected $table = 'competitors_listings';

    public function competitor()
    {
    	return $this->belongsTo('App\Competitor', 'competitor_id');
    }

    public function doRegexMatch($url, $regex)
    {
        $html = file_get_contents($url);
        preg_match('#'.$regex.'#', $html, $matches);
        return ($matches[1] * 100);
    }

    public function game()
    {
    	return $this->belongsTo('App\Game', 'game_id');
    }

    public function getGameNameAttribute()
    {
        if ($this->game) return $this->game->name;
        return '';
    }

    public function getLatestPriceBuyFormatAttribute()
    {
        if ($this->latest_price_buy == 0) return '';
        return number_format($this->latest_price_buy/100, 2);
    }

    public function getLatestPriceNewFormatAttribute()
    {
        if ($this->latest_price_new == 0) return '';
        return number_format($this->latest_price_new/100, 2);
    }

    public function getLatestPricePreownFormatAttribute()
    {
        if ($this->latest_price_preown == 0) return '';
        return number_format($this->latest_price_preown/100, 2);
    }

    public function getLatestPriceVoucherFormatAttribute()
    {
        if ($this->latest_price_voucher == 0) return '';
        return number_format($this->latest_price_voucher/100, 2);
    }

    public function getProductNameAttribute()
    {
        if ($this->product) return $this->product->name;
        return '';
    }

    public function product()
    {
    	return $this->belongsTo('App\Product', 'product_id');
    }

    public function prices()
    {
    	return $this->hasMany('App\CompetitorPrice', 'listing_id');
    }

    public function updatePrice()
    {
        if ($this->url_new)
        {
            $update['price_new'] = $this->doRegexMatch($this->url_new, $this->competitor->regex_price_new);
        }
        if ($this->url_preown)
        {
            $update['price_preown'] = $this->doRegexMatch($this->url_preown, $this->competitor->regex_price_preown);
        }
        if ($this->url_buy)
        {
            $update['price_buy'] = $this->doRegexMatch($this->url_buy, $this->competitor->regex_price_buy);
        }
        if ($this->url_voucher)
        {
            $update['price_voucher'] = $this->doRegexMatch($this->url_voucher, $this->competitor->regex_price_voucher);
        }
        
        $update['listing_id'] = $this->id;
        $compPrice = new CompetitorPrice($update);
        $compPrice->save();

        $this->latest_price_new = $update['price_new'] ?? 0;
        $this->latest_price_preown = $update['price_preown'] ?? 0;
        $this->latest_price_buy = $update['price_buy'] ?? 0;
        $this->latest_price_voucher = $update['price_voucher'] ?? 0;
        $this->save();
    }
}
