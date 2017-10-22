<?php

namespace App;

use App\Category;
use App\Rating;
use App\System;
use Auth;
use Curl;
use File;
use IGAD;
use IGDB;
use Illuminate\Database\Eloquent\Model;
use Parser;
use Storage;

class Game extends Model
{
	protected $fillable = ['name', 'system_id', 'gamesdb_id', 'rating_id', 'category_id', 'developer', 'publisher', 'description', 'trailer_url', 'release_date', 'is_premium', 'min_players', 'max_players', 'is_local_coop', 'is_online_coop', 'slug', 'collection_id', 'franchise_id', 'publisher_id', 'developer_id', 'esrb_rating', 'esrb_synopsis', 'pegi_rating', 'pegi_synopsis', 'timetobeat_quick', 'timetobeat_normal', 'timetobeat_slow', 'rating', 'rating_count', 'max_gamerscore', 'xbox_id', 'playstation_id'];
    protected $table   = 'games';

    public function assignments()
    {
        return $this->hasMany('App\Assignment', 'game_id');
    }

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
            <a href="'.route('game.show', $this->id).'">
                <img src="/storage/'.$this->thumb_url.'" height="200" width="150"> <br />
                '.$this->name.'</a><br />
            '.$this->num_in_stock_format.' in stock, '.$this->num_available_format.' available
        </div>';
    }

    public function getEsrbPictureAttribute()
    {
        switch ($this->esrb_rating)
        {
            case 1: return '/images/esrb/ratingpending.svg';
            case 2: return '/images/esrb/earlychildhood.svg';
            case 3: return '/images/esrb/everyone.svg';
            case 4: return '/images/esrb/everyone10plus.svg';
            case 5: return '/images/esrb/teen.svg';
            case 6: return '/images/esrb/mature.svg';
            case 7: return '/images/esrb/adultsonly.svg';
        }
    }

    public function getNumAvailableFormatAttribute()
    {
        return $this->num_available + 0;
    }

    public function getNumInStockFormatAttribute()
    {
        return $this->num_in_stock + 0;
    }

    public function getNumOnRentalAttribute()
    {
        return $this->num_in_stock - $this->num_available;
    }

    public function getPegiPictureAttribute()
    {
        switch ($this->pegi_rating)
        {
            case 1: return '/images/pegi/3.svg';
            case 2: return '/images/pegi/7.svg';
            case 3: return '/images/pegi/12.svg';
            case 4: return '/images/pegi/16.svg';
            case 5: return '/images/pegi/18.svg';
        }
    }

    //This is the HTML to show the box for the wishlist itself. 
    public function getWishlistAttribute()
    {
        return '<div class="col-lg-12">
            <h2>'.$this->name.'</h2>
        <input type="hidden" name="order[]" value="'.$this->id.'">
        </div>';
    }

    public function incrementStock($amount)
    {
        $this->num_in_stock = $this->num_in_stock + $amount;
        $this->save();
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

    public function refreshAchievementInfo()
    {
        if (!$this->xbox_id) return false;

        $achievementInfo = IGAD::getAchievements(Auth::user()->xbox_id, $this->xbox_id);

        dd($achievementInfo);

        dd('achievement');
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
        $releaseDate = $api->first_release_date ?? 0;
        $updateArray['release_date'] = date('Y-m-d', (int) $releaseDate);
        
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

        if (isset($api->cover))
        {
            $image = 'http:'.str_replace('t_thumb', 't_cover_big', $api->cover->url);
            $this->updateImage($image);
        }
        
        $this->update($updateArray);

        $this->save();
    }

    public function refreshInfo()
    {
        $this->refreshAchievementInfo();
        return $this->refreshGameDBInfo();
    }

    public function rentals()
    {
        return $this->hasMany('App\Rental', 'game_id');
    }

    public function screenshots()
    {
        return $this->hasMany('App\Screenshot', 'game_id');
    }

    public function stock()
    {
        return $this->hasMany('App\Stock', 'game_id');
    }

    public function system()
    {
        return $this->belongsTo('App\System', 'system_id');
    }

    public function updateImage($url)
    {
        $file  = md5('mainpicture'.$this->id).'.'.File::extension($url);
        $thumb = md5('thumb'.$this->id).'.'.File::extension($url);
        
        if (!File::exists('../storage/app/public/games_boxes/'))
        {
            File::makeDirectory('../storage/app/public/games_boxes/', 0777, true);
        }
        if (!File::exists('../storage/app/public/games_thumbs/'))
        {
            File::makeDirectory('../storage/app/public/games_thumbs/', 0777, true);
        }

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
