<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return view('plans.index')->with(['plans' => Plan::get()]);
    }

    public function show($id)
    {
    	$plan = Plan::find($id);
        return view('plans.show')->with(['plan' => $plan]);
    }

    public function store(Request $request)
    {
          // get the plan after submitting the form
          $plan = Plan::findOrFail($request->plan);

          // subscribe the user
          $request->user()->newSubscription('main', $plan->braintree_plan)->create($request->payment_method_nonce);

          // redirect to home after a successful subscription
          return redirect('user.subscription');
    }
}
