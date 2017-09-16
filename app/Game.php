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
	protected $fillable = ['name', 'system_id', 'gamesdb_id', 'rating_id', 'category_id', 'developer', 'publisher', 'description', 'trailer_url', 'release_date', 'is_premium', 'min_players', 'max_players', 'is_local_coop', 'is_online_coop', 'slug', 'collection_id', 'franchise_id', 'publisher_id', 'developer_id', 'esrb_rating', 'esrb_synopsis', 'pegi_rating', 'pegi_synopsis', 'timetobeat_quick', 'timetobeat_normal', 'timetobeat_slow', 'rating', 'rating_count'];
    protected $table   = 'games';

    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id');
    }

    public function developer()
    {
        return $this->belongsTo('App\Developer', 'developer_id');
    }

    public function franchise()
    {
        return $this->belongsTo('App\Franchise', 'franchise_id');
    }

    public function genres()
    {
        return $this->belongsToMany('App\Genre', 'link_games_genres', 'game_id', 'genre_id');
    }

    public function getBoxAttribute()
    {
        return '<div class="col-lg-3">

            <img src="/storage/'.$this->thumb_url.'" height="200" width="150"> <br />
            <a href="'.route('game.show', $this->id).'">'.$this->name.'</a></b>
        </div>';
    }

    public function modes()
    {
        return $this->belongsToMany('App\Mode', 'link_games_modes', 'game_id', 'mode_id');
    }

    //Returns true if there is a user logged in and the game is on their wishlist. False otherwise. 
    public function onWishlist()
    {
        if (!Auth::check()) return false;

        return count($this->wishlists()->where('user_id', Auth::id())->get());
    }

    public function publisher()
    {
        return $this->belongsTo('App\Publisher', 'publisher_id');
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
        $updateArray['name'] = $api->name ?? '';
        $updateArray['description'] = $api->summary ?? '';
        $updateArray['collection_id'] = $api->collection ?? 0;
        $updateArray['franchise_id'] = $api->franchise ?? 0;
        $updateArray['publisher_id'] = $api->publishers[0] ?? 0;
        $updateArray['developer_id'] = $api->developers[0] ?? 0;
        $updateArray['esrb_rating'] = $api->esrb->rating ?? 0;
        $updateArray['esrb_synopsis'] = $api->esrb->synopsis ?? '';
        $updateArray['pegi_rating'] = $api->pegi->rating ?? 0;
        $updateArray['pegi_synopsis'] = $api->pegi->synopsis ?? '';
        $updateArray['timetobeat_slow'] = $api->time_to_beat->completely ?? 0;
        $updateArray['timetobeat_normal'] = $api->time_to_beat->normally ?? 0;
        $updateArray['timetobeat_quick'] = $api->time_to_beat->hastly ?? 0;
        $updateArray['rating'] = $api->aggregated_rating ?? 0;
        $updateArray['rating_count'] = $api->aggregated_rating_count ?? 0;
        $updateArray['release_date'] = date('Y-m-d', (int) $api->first_release_date ?? 0);
        $image = 'http:'.str_replace('t_thumb', 't_cover_big', $api->cover->url);
        
        $this->genres()->sync($api->genres ?? array());
        $this->modes()->sync($api->game_modes ?? array());

        $websiteArray = $api->websites ?? array();
        foreach ($websiteArray as $website)
        {
            if (!count($this->websites->where('url', $website->url)))
            {
                $this->websites()->create([
                        'url' => $website->url,
                        'category_id' => $website->category
                    ]);
            }
        }

        $videoArray = $api->videos ?? array();
        foreach ($videoArray as $video)
        {
            if (!count($this->videos->where('youtube_id', $video->video_id)))
            {
                $this->videos()->create([
                        'name' => $video->name,
                        'youtube_id' => $video->video_id
                    ]);
            }
        }

        $this->updateImage($image);

        $this->update($updateArray);

        $this->save();
    }

    public function screenshots()
    {
        return $this->hasMany('App\Screenshot', 'game_id');
    }

    public function system()
    {
        return $this->belongsTo('App\System', 'system_id');
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

    public function videos()
    {
        return $this->hasMany('App\Video', 'game_id');
    }

    public function websites()
    {
        return $this->hasMany('App\Website', 'game_id');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Wishlist', 'game_id');
    }
}
