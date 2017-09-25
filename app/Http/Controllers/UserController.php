<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            session()->flash('danger', 'You must be logged in to do that');
            return redirect()->route('login');
        } 
        $user = Auth::user();

        return view('user.form', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->update($request->all());

        $request->session()->flash('success', 'The user has successfully been edited!');

        return redirect()->route('user.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function account()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }

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

        $request->session()->flash('success', 'Your wishlist has been updated!');

        return redirect()->route('user.account');
    }

    public function subscription()
    {
        if(!Auth::check())
        {
            return redirect()->route('login');
        }

        $user = Auth::user();

        return view('user.subscription', ['user' => $user]);
    }
}
