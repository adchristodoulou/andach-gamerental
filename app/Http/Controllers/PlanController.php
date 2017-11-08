<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionChange;
use App\Mail\SubscriptionNew;
use App\Plan;
use Illuminate\Http\Request;
use Mail;

class PlanController extends Controller
{
    public function index()
    {
        return view('plans.index')->with(['plans' => Plan::get()]);
    }

    public function show($id)
    {
    	$plan = Plan::where('slug', $id)->first();
      return view('plans.show')->with(['plan' => $plan]);
    }

    public function store(Request $request)
    {
          // get the plan after submitting the form
          $plan = Plan::findOrFail($request->plan);

          // subscribe the user
          if (!$request->user()->subscribed('main')) {
            $request->user()->newSubscription('main', $plan->braintree_plan)->create($request->payment_method_nonce);
            $request->session()->flash('success', 'You have successfully subscribed to the plan <strong>"'.$plan->name.'"</strong>');
            Mail::to($request->user())->send(new SubscriptionNew($plan));
          } else {
            $request->session()->flash('success', 'You have changed to the plan <strong>"'.$plan->name.'"</strong>');
            $request->user()->subscription('main')->swap($plan->braintree_plan);
            Mail::to($request->user())->send(new SubscriptionChange($plan));
          }

          // redirect to home after a successful subscription
          return redirect('user/subscription');
    }
}
