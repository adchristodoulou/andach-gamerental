<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionChange;
use App\Mail\SubscriptionNew;
use App\Plan;
use Auth;
use Illuminate\Http\Request;
use Mail;

class PlanController extends Controller
{
    public function index()
    {
        return view('plans.index')->with(['plans' => Plan::where('is_visible', 1)->get()]);
    }

    public function show($id)
    {
      	$plan = Plan::where('slug', $id)->firstOrFail();
        if (Auth::check())
        {
            if (Auth::user()->isOnPlan($plan))
            {
                //Then user is already subscribed to this plan
                $showPurchaseForm = false;
            } else {
                $showPurchaseForm = true;
            }
        } else {
            $showPurchaseForm = false;
        }
        

        return view('plans.show')->with(['plan' => $plan, 'showPurchaseForm' => $showPurchaseForm]);
    }

    public function store(Request $request)
    {
        // get the plan after submitting the form
        $plan = Plan::find($request->plan_id);

        if (!$plan)
        {
            session()->flash('danger', 'Plan not found.');
            return redirect()->route('home');
        }

        if (!Auth::check())
        {
            session()->flash('danger', 'You are not logged in.');
            return redirect()->route('home');
        }

        Auth::user()->worldpay_token = $request->token;
        Auth::user()->save();

        //The subscribeTo() function takes care of whether we want to switch or do a new subscription. 
        if (Auth::user()->subscribeTo($plan))
        {
            // redirect to home after a successful subscription
            return redirect()->route('plan.thanks')->with('data', ['plan' => $plan->name, 'user' => $request->user()->firstname]);
        } else {
            session()->flash('danger', 'There was an unidentified error');
            return redirect()->route('plan.show', $plan->slug);
        }

    }

    public function thanks()
    {
        return view('plans.thanks');
    }
}
