<?php

namespace App;

use App\Category;
use App\Rating;
use App\System;
use Auth;
use Curl;
use File;
use IGDB;
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

    //This is the HTML to show the box for the wishlist itself. 
    public function getWishlistAttribute()
    {
        return '<div class="col-lg-12">

            <img src="/storage/'.$this->thumb_url.'" height="200" width="150"> <br />
            <a href="'.route('game.show', $this->id).'">'.$this->name.'</a></b>
        </div>';
    }

    //Returns true if there is a user logged in and the game is on their wishlist. False otherwise. 
    public function onWishlist()
    {
        if (!Auth::check()) return false;

        return count($this->wishlists()->where('user_id', Auth::id())->get());
    }

    public function rating()
    {
    	return $this->belongsTo('App\Rating', 'rating_id');
    }

    public function refreshGameDBInfo()
    {
        if (!$this->gamesdb_id)
        {
            //Then we need to show to the user the list of IDs. 
            $api = IGDB::searchGames($this->name);
            foreach ($api as $game)
            {
                $errors[] = $game->id.' - '.$game->name;
            }

            return $errors;
        }

        $api = IGDB::getGame($this->gamesdb_id);
        $updateArray['name'] = $api->name;
        $updateArray['description'] = $api->summary;
        $image = 'http:'.str_replace('t_thumb', 't_cover_big', $api->cover->url);
        
        //dd($api);

        $this->updateImage($image);

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
