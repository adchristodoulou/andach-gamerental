<?php

namespace App;

use App\Wishlist;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function accounts()
    {
        return $this->hasMany('App\LinkedSocialAccount');
    }

    public function addToWishlist($gameID)
    {
        if(count($this->wishlist()->where('game_id', $gameID)->get()))
        {
            session()->flash('success', 'You aleady had this game on your wishlist.');
            return true;
        } else {
            session()->flash('success', 'This game has been added to your wishlist.');
            $wish = new Wishlist(['game_id' => $gameID, 'order' => 1000]);
            $this->wishlist()->save($wish);
        }
    }

    public function deleteFromWishlist($gameID)
    {
        if(count($this->wishlist()->where('game_id', $gameID)->get()))
        {
            session()->flash('success', 'This game has been removed from your wishlist.');
            $this->wishlist()->where('game_id', $gameID)->delete();
            return true;
        } else {
            session()->flash('success', 'This game wasn\'t on your wishlist in the first place. What do you want us to do, purge it from existance? No, other people might want to rent it.');
        }
    }

    public function wishlist()
    {
        return $this->hasMany('App\Wishlist', 'user_id');
    }
}
