<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionCancel;
use App\Mail\SubscriptionResume;
use App\Invoice;
use App\Rental;
use App\User;
use App\Wishlist;
use Auth;
use Illuminate\Http\Request;
use Mail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function account()
    {
        $user = Auth::user();

        return view('user.account', ['user' => $user]);
    }

    public function accountUpdate(Request $request)
    {
        $user = Auth::user();

        $order = array_flip($request->order);

        foreach ($user->wishlists as $wish)
        {
            $wish->order = $order[$wish->game_id];
            $wish->save();
        }

        if (isset($request->delete))
        {
            foreach ($request->delete as $gameID)
            {
                $wishlist = Wishlist::where('user_id', $user->id)->where('game_id', $gameID)->first();
                $wishlist->delete();
            }
        }

        $request->session()->flash('success', 'Your wishlist has been updated!');

        return redirect()->route('user.account');
    }

    public function cancelSubscription(Request $request)
    {
        if($request->confirm)
        {
            Auth::user()->subscription('main')->cancel();
            $request->session()->flash('success', 'You have cancelled your subscription.');

            $user = Auth::user();
            Mail::to($user)->send(new SubscriptionCancel($this->subscription('main')->ends_at));

            return view('user.subscription', ['user' => $user]);
        }

        return view('user.cancelsubscription');
    }

    public function edit()
    {
        $user = Auth::user();

        return view('user.form', ['user' => $user]);
    }

    public function history()
    {
        $rentals = Rental::where('user_id', Auth::id())->whereNotNull('date_of_delivery')->get();

        return view('user.history', ['rentals' => $rentals]);
    }

    public function invoiceList()
    {
        $invoices = Invoice::where('user_id', Auth::id())->get();

        return view('user.invoicelist', ['invoices' => $invoices]);
    }

    public function invoiceShow($id)
    {
        $invoice = Invoice::where('user_id', Auth::id())->where('id', $id)->first();

        return view('user.invoiceshow', ['invoice' => $invoice]);
    }

    public function registerAddress()
    {
        $user = Auth::user();

        return view('user.registeraddress', ['user' => $user]);
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'shipping_address1' => 'required',
            'shipping_postcode' => 'required',
        ]);

        $user = User::find(Auth::id());
        $user->update($request->all());
        $request->session()->flash('success', 'You have successfully added your address details. Now choose your plan. ');
        return redirect()->route('plan.index');
    }

    public function resumeSubscription(Request $request)
    {
        Auth::user()->subscription('main')->resume();

        $request->session()->flash('success', 'Your subscription has been set to resume.');
        $user = Auth::user();
        Mail::to($user)->send(new SubscriptionResume());

        return view('user.subscription', ['user' => $user]);
    }

    public function subscription()
    {
        $user = Auth::user();

        return view('user.subscription', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'shipping_address1' => 'required',
            'shipping_postcode' => 'required',
        ]);
                
        $user = Auth::user();

        $user->update($request->all());

        if (!$request->marketing_subscribe)
        {
            $user->marketing_subscribe = 0;
            $user->save();
        }

        $request->session()->flash('success', 'You have successfully changed your account details.');

        return redirect()->route('user.edit');
    }
}
