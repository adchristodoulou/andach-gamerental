<?php

namespace App;

use App\Invoice;
use App\Mail\UserAgeLimit;
use App\Plan;
use App\Wishlist;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mail;

class User extends Authenticatable
{
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

    public function cancelSubscription()
    {
        $sub = $this->currentSubscription();
        return $sub->cancel();
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

    public function cart()
    {
        return $this->hasMany('App\Cart', 'user_id');
    }

    public function charge($amount, $lineDescription = '')
    {
        if (!$this->worldpay_token)
        {
            session()->flash('danger', 'There is no Worldpay Token.');
            return false;
        }

        //https://developer.worldpay.com/jsonapi/api#orders
        $array = array(
                'token' => $this->worldpay_token,
                'orderType;' => 'RECURRING', 
                'amount' => intval($amount * 100),
                'currencyCode' => 'GBP',
                'name' => $this->first_name.' '.$this->last_name,
                'orderDescription' => 'Purchase from Andach Games',
                'customerOrderCode' => Invoice::nextInvoiceID(),
                'billingAddress' => array(
                        "address1"=> $this->billing_address1,
                        "address2"=> $this->billing_address2,
                        "address3"=> $this->billing_address3,
                        "postalCode"=> $this->billing_postcode,
                        "city"=> $this->billing_town,
                        "state"=> '',
                        "countryCode"=> 'GB',
                    ),
                'deliveryAddress' => array(
                        "address1"=> $this->shipping_address1,
                        "address2"=> $this->shipping_address2,
                        "address3"=> $this->shipping_address3,
                        "postalCode"=> $this->shipping_postcode,
                        "city"=> $this->shipping_town,
                        "state"=> '',
                        "countryCode"=> 'GB',
                    ),
                'shopperEmailAddress' => $this->email,
                'shopperIpAddress' => \Request::ip(),
            );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.worldpay.com/v1/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($array),
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
                'Authorization: '.env('WORLDPAY_SERVICE_KEY'),
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            dd('There has been a payment error. Please report this immediately to the website owner. Your card has not been charged.');
        } else {
            $json = json_decode($response);

            if (!isset($json->paymentStatus))
            {
                return false;
            }

            if ($json->paymentStatus == 'SUCCESS')
            {
                $this->createSubscriptionInvoice($amount, $lineDescription);
                return true;
            } else {
                return false;
            }
        }
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

    public function createSubscriptionInvoice($amount, $lineDescription = '')
    {
        $create['email'] = $this->email;
        $create['date_of_invoice'] = date('Y-m-d');

        $create['shipping_address1'] = $this->shipping_address1;
        $create['shipping_address2'] = $this->shipping_address2;
        $create['shipping_address3'] = $this->shipping_address3;
        $create['shipping_town'] = $this->shipping_town;
        $create['shipping_county'] = $this->shipping_county;
        $create['shipping_postcode'] = $this->shipping_postcode;

        $create['billing_address1'] = $this->billing_address1;
        $create['billing_address2'] = $this->billing_address2;
        $create['billing_address3'] = $this->billing_address3;
        $create['billing_town'] = $this->billing_town;
        $create['billing_county'] = $this->billing_county;
        $create['billing_postcode'] = $this->billing_postcode;

        $lineCreate['description'] = $lineDescription;
        $lineCreate['quantity_invoiced'] = 1;
        $lineCreate['net'] = $amount;
        $lineCreate['gross'] = $amount;
        $lineCreate['net_per_item'] = $amount;
        $lineCreate['gross_per_item'] = $amount;

        $invoice = $this->invoices()->create($create);
        $invoice->lines()->create($lineCreate);

        $invoice->finalise();
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
        if (!$this->currentSubscription()) return false;

        return $this->currentSubscription()->plan;
    }

    public function currentSubscription()
    {
        return $this->subscriptions()->current()->first();
    }

    public function deleteFromWishlist($gameID, $flash = true)
    {
        if(count($this->wishlists()->where('game_id', $gameID)->get()))
        {
            $flashMessage = 'This game has been removed from your wishlist.';
            $this->wishlists()->where('game_id', $gameID)->delete();
            return true;
        } else {
            $flashMessage = 'This game wasn\'t on your wishlist in the first place.';
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

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice', 'user_id');
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isOnPlan($plan)
    {
        $currentPlan = $this->currentPlan();

        if (!$currentPlan) 
        {
            return false;
        }

        return $this->currentPlan()->id == $plan->id;
    }

    //Returns true if the user is subscribed, regardless of whether they are in a free trial period, after which billing will begin automatically, or whether they're on their grace period. 
    public function isSubscribed()
    {
        $sub = $this->currentSubscription();
        if ($sub) 
        {
            return true;
        }

        return false;
    }

    public function isSubscribedInFreeTrial()
    {
        //We don't have free trials at the moment. 
        return false;
    }

    public function isSubscribedOnGracePeriod()
    {
        $sub = $this->currentSubscription();
        if ($sub->ends_at) 
        {
            //If we have an end date, we must be on our grace period. 
            return true;
        }

        return false;
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

    public function resumeSubscription()
    {
        $sub = $this->currentSubscription();
        return $sub->resume();
    }

    public function subscribeTo(Plan $plan)
    {
        if ($this->isSubscribed())
        {
            session()->flash('info', 'already subscribed');
            return $this->subscribeToChanged($plan);
        } else {
            session()->flash('info', 'not subscribed. new plan needed');
            return $this->subscribeToNew($plan);
        }
    }

    public function subscribeToChanged(Plan $plan)
    {
        $sub = $this->currentSubscription();
        $charge = $sub->calculateChargeToSwitchTo($plan);
        dd($charge);
        //Need to work out what to do whtn this is negative. 

        if ($this->charge($charge, 'Additional charge for plan '.$plan->name.' from '.date('Y-m-d').' to '.$sub->next_billing_date))
        {
            dd('only the charging for the plan is done. switching plans doesnt work yet');
        } else {
            session()->flash('danger', 'We could not put through the charge to switch plans.');
            return false;
        }
    }

    public function subscribeToNew(Plan $plan)
    {
        $create['plan_id'] = $plan->id;
        $create['starts_at'] = date('Y-m-d');
        $create['next_billing_date'] = date('Y-m-d', strtotime('+1 month'));

        if (!$this->charge($plan->cost, 'Charge for plan '.$plan->name.' from '.$create['starts_at'].' to '.$create['next_billing_date']))
        {
            session()->flash('danger', 'We could not put through the charge for the new plan.');
            return false;
        } else {
            $create['plan_id'] = $plan->id;
            $create['starts_at'] = date('Y-m-d');
            $create['next_billing_date'] = date('Y-m-d', strtotime('+1 month'));

            $this->subscriptions()->create($create);

            $sub = $this->currentSubscription();

            $addCharge['starts_at'] = $create['starts_at'];
            $addCharge['ends_at'] = $create['next_billing_date'];
            $addCharge['charge'] = $plan->cost;
            $addCharge['date_charge_taken'] = date('Y-m-d');
            $sub->addSuccessfulCharge($addCharge);

            return true;
        }
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription', 'user_id');
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
