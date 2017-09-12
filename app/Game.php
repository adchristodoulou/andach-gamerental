<?php

namespace App;

use App\Category;
use App\Rating;
use App\System;
use Curl;
use File;
use Illuminate\Database\Eloquent\Model;
use Parser;
use Storage;

class Game extends Model
{
	protected $fillable = ['name', 'system_id', 'gamesdb_id', 'rating_id', 'category_id', 'developer', 'publisher', 'description', 'trailer_url', 'release_date', 'is_premium', 'min_players', 'max_players', 'is_local_coop', 'is_online_coop'];
    protected $table   = 'games';

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function getBoxAttribute()
    {
        return '<div class="col-lg-3">

            <img src="/storage/'.$this->thumb_url.'" height="200" width="150"> <br />
            <a href="'.route('game.show', $this->id).'">'.$this->name.'</a></b>
        </div>';
    }

    public function rating()
    {
    	return $this->belongsTo('App\Rating', 'rating_id');
    }

    public function refreshGameDBInfo()
    {
        if (!$this->gamesdb_id) return false;

        $xml = file_get_contents('http://thegamesdb.net/api/GetGame.php?id='.$this->gamesdb_id);
        $parser = Parser::xml($xml);

        $array['name'] = 'GameTitle';
        $array['system_id'] = 'PlatformId';
        $array['developer'] = 'Developer';
        $array['publisher'] = 'Publisher';
        $array['description'] = 'Overview';
        $array['trailer_url'] = 'YouTube';
        $array['release_date'] = 'ReleaseDate';

        foreach ($array as $key => $gameKey)
        {
            if (isset($parser['Game'][$gameKey]))
            {
                $updateArray[$key] = $parser['Game'][$gameKey];
            }
        }

        if(isset($parser['Game']['Images']['boxart']['@thumb']))
        {
            $url = $parser['baseImgUrl'].$parser['Game']['Images']['boxart']['@thumb'];
            $this->updateImage($url);
        }

        $this->update($updateArray);

        $this->save();
    }

    public function updateImage($url)
    {
        $file  = md5('mainpicture'.$this->id).'.'.File::extension($url);
        $thumb = md5('thumb'.$this->id).'.'.File::extension($url);
        
        //dd('/storage/app/public/'.$file);
        Curl::to($url)->withContentType('image/'.File::extension($url))->download('../storage/app/public/games_boxes/'.$file);
        Curl::to($url)->withContentType('image/'.File::extension($url))->download('../storage/app/public/games_thumbs/'.$thumb);

        $this->picture_url = 'games_boxes/'.$file;
        $this->thumb_url   = 'games_thumbs/'.$thumb;

        $this->save();
    }

    public function system()
    {
    	return $this->belongsTo('App\System', 'system_id');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Wishlist', 'game_id');
    }
}
