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
    protected $fillable = ['name', 'email', 'password', 'first_name', 'middle_names', 'last_name', 'telephone', 'shipping_address1', 'shipping_address2', 'shipping_address3', 'shipping_town', 'shipping_county', 'shipping_postcode', 'billing_address1', 'billing_address2', 'billing_address3', 'billing_town', 'billing_county', 'billing_postcode', 'xbox_id', 'xbox_username', 'psn_id', 'psn_username', 'marketing_subscribe'];

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

    public function cart()
    {
        return $this->hasMany('App\Cart', 'user_id');
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact', 'user_id');
    }

    public function canReceiveGames()
    {
        $array['numgames'] = $this->num_games_on_rental;
        $array['gamesrented'] = $this->games_rented_this_month;
        $array['currentmax'] = $this->currentMaxGames();
        $array['currentmaxpermonth'] = $this->currentMaxGamesPerMonth();

        //dd($array);

        return ($this->num_games_on_rental < $this->currentMaxGames()) && 
            $this->games_rented_this_month < $this->currentMaxGamesPerMonth();
    }

    public function currentMaxGames()
    {
        return $this->currentPlan()->max_games_simultaneously;
    }

    public function currentMaxGamesPerMonth()
    {
        return $this->currentPlan()->max_games_per_month;
    }

    public function currentPlan()
    {
        if (!count($this->currentSubscription())) return false;
        
        $sub = $this->currentSubscription()->first();

        $plan = Plan::where('braintree_plan', $sub->braintree_plan)->first();

        return $plan;
    }

    public function currentSubscription()
    {
        return $this->hasMany('App\Subscription', 'user_id');
    }

    public function deleteFromWishlist($gameID, $flash = true)
    {
        if(count($this->wishlists()->where('game_id', $gameID)->get()))
        {
            $flashMessage = 'This game has been removed from your wishlist.';
            $this->wishlists()->where('game_id', $gameID)->delete();
            return true;
        } else {
            $flashMessage = 'This game wasn\'t on your wishlist in the first place. What do you want us to do, purge it from existance? No, other people might want to rent it.';
        }

        if ($flash)
        {
            session()->flash('success', $flashMessage);
        }
    }

    public function deliveryNotes()
    {
        return $this->hasMany('App\DeliveryNote', 'user_id');
    }

    //Returns the first Stock object on this user's wishlist. 
    public function firstAvailableStockItem()
    {
        foreach ($this->wishlistGames as $game)
        {
            $stock = Stock::where([
                ['game_id', $game->id],
                ['currently_in_stock', 1]
            ])->first();

            if ($stock) return $stock;
        }

        return false;
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice', 'user_id');
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function pages()
    {
        return $this->hasMany('App\Page', 'author_id');
    }

    public function recordGameAssigned()
    {
        $this->games_rented_this_month = $this->games_rented_this_month + 1;
        $this->num_games_on_rental     = $this->num_games_on_rental + 1;
        $this->save();
    }

    public function recordGamePosted()
    {
        
    }

    public function recordGameReturned()
    {
        $this->num_games_on_rental = $this->num_games_on_rental - 1;
        $this->save();
    }

    public function rentals()
    {
        return $this->hasMany('App\Rental', 'user_id');
    }

    public function resetMonthlyRentalCount()
    {
        $this->games_rented_this_month = 0;
        $this->save();
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
