<?php

namespace App;

use App\Mail\UserAgeLimit;
use App\Wishlist;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Mail;

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
            //Check that the account is not age restricted
            if (!$this->gameAgeRatingAppropriate($gameID))
            {
                $game = Game::find($gameID);
                session()->flash('danger', 'The game cannot be added to your wishlist because its age rating of '.$game->pegiRating->name.' is higher than your account limit of '.$this->maximum_age.'.');
                return false;
            }
            session()->flash('success', 'This game has been added to your wishlist.');
            $wish = new Wishlist(['game_id' => $gameID, 'order' => 1000]);
            $this->wishlists()->save($wish);
            return true;
        }
    }
    
    public function ageLimitToConfirm($age)
    {
        $this->maximum_age_hash = uniqid();
        $this->maximum_age_expiry = date('Y-m-d h:i:d', strtotime('+24 hours'));
        $this->maximum_age_held = $age;
        $this->save();
        
        Mail::to($this)->send(new UserAgeLimit($this));
        Mail::to('andreas@andachrental.co.uk')->send(new UserAgeLimit($this));
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
    
    public function comments()
    {
        return $this->hasMany('App\PageComment', 'user_id');
    }
    
    public function confirmAgeLimit($hash)
    {
        if (strtotime($this->maximum_age_expiry) < strtotime('now'))
        {
            return false;
        }
        
        if ($this->maximum_age_hash != $hash)
        {
            return false;
        }
        
        $this->maximum_age = $this->maximum_age_held;
        $this->save();
        
        return true;
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
    
    public function gameAgeRatingAppropriate($gameID)
    {
        if (!$this->maximum_age)
        {
            return true;
        }
        
        $game = Game::find($gameID);
        
        if (!$game->pegiRating) 
        {
            return false;
        }
        
        if ($game->pegiRating->minimum_age > $this->maximum_age)
        {
            return false;
        } else {
            return true;
        }
    }
    
    public function getAgeLimitBoxAttribute()
    {
        if ($this->maximum_age)
        {
            $return = 'There is currently a maximum age limit set on this account, which is '.$this->maximum_age.'.';
        } else {
            $return = 'There is no maximum age limit currently set on this account';
        }
        
        return '<div class="alert alert-info">'.e($return).'</div>';
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
