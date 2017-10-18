<?php

namespace App;

use App\Wishlist;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Billable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'middle_names', 'last_name', 'telephone', 'shipping_address1', 'shipping_address2', 'shipping_address3', 'shipping_town', 'shipping_county', 'shipping_postcode', 'billing_address1', 'billing_address2', 'billing_address3', 'billing_town', 'billing_county', 'billing_postcode'
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
        if(count($this->wishlists()->where('game_id', $gameID)->get()))
        {
            session()->flash('success', 'You aleady had this game on your wishlist.');
            return true;
        } else {
            session()->flash('success', 'This game has been added to your wishlist.');
            $wish = new Wishlist(['game_id' => $gameID, 'order' => 1000]);
            $this->wishlists()->save($wish);
        }
    }

    public function assignmentRuns()
    {
        return $this->hasMany('App\AssignmentRun', 'user_id');
    }

    public function assignments()
    {
        return $this->hasMany('App\Assignment', 'user_id');
    }

    //TODO: Write this.
    public function currentMaxGames()
    {
        return 1;
    }

    public function currentSubscription()
    {
        return $this->hasMany('App\Subscription', 'user_id');
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

    public function rentals()
    {
        return $this->hasMany('App\Rental', 'user_id');
    }

    public function wishlistGames()
    {
        return $this->belongsToMany('App\Game', 'wishlist', 'user_id', 'game_id')->orderBy('order');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Wishlist', 'user_id');
    }
}
