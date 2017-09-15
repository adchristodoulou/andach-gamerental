<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Rating;
use App\System;
use Auth;
use Illuminate\Http\Request;
use Image;
use Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::paginate(20);

        return view('game.index', ['games' => $games]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('name', 'id');
        $ratings    = Rating::all()->pluck('name', 'id');
        $systems    = System::all()->pluck('name', 'id');

        return view('game.form', ['categories' => $categories, 'ratings' => $ratings, 'systems' => $systems]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $game = Game::create($request->all());

        if(isset($request->picture))
        {
            $game->picture_url = $request->picture->store('games_boxes', 'public');
            $game->thumb_url   = $request->picture->store('games_thumbs', 'public');
        }
        $game->save();
        $game->refreshGameDBInfo();

        $request->session()->flash('success', 'The game has successfully been added!');

        return redirect()->route('game.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::find($id);

        return view('game.show', ['game' => $game]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all()->pluck('name', 'id');
        $ratings    = Rating::all()->pluck('name', 'id');
        $systems    = System::all()->pluck('name', 'id');
        $game       = Game::find($id);

        return view('game.form', ['game' => $game, 'categories' => $categories, 'ratings' => $ratings, 'systems' => $systems]);

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
        $game = Game::find($id);

        $game->update($request->all());

        if(isset($request->picture))
        {
            $game->picture_url = $request->picture->store('games_boxes', 'public');
            $game->thumb_url   = $request->picture->store('games_thumbs', 'public');
        }

        $game->save();
        $errors = $game->refreshGameDBInfo();

        if (count($errors))
        {
            $request->session()->flash('success', implode($errors, "\n"));

            return redirect()->route('game.edit', $id);
        }

        $request->session()->flash('success', 'The game has successfully been edited!');

        return redirect()->route('game.edit', $id);
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

    public function addToWishlist(Request $request)
    {
        if(Auth::check())
        {
            Auth::user()->addToWishlist($request->id);
        } else {
            $request->session()->flash('success', 'You need to login to add a game to your wishlist!');
            return redirect()->route('login');
        }

        return redirect()->route('game.show', $request->id);
    }

    public function deleteFromWishlist(Request $request)
    {
        if(Auth::check())
        {
            Auth::user()->deleteFromWishlist($request->id);
        } else {
            $request->session()->flash('success', 'You are not logged in.');
            return redirect()->route('login');
        }

        return redirect()->route('game.show', $request->id);
    }

    public function homepage()
    {
        $xboxone = Game::where('system_id', 4920)->get()->random(4);
        $ps4     = Game::where('system_id', 4919)->get()->random(4);
        return view('home', ['xboxone' => $xboxone, 'ps4' => $ps4]);
    }

    public function search($system, $category = null)
    {
        $system = System::where('url', $system)->first();

        if ($category)
        {
            $category = Category::where('url', $category)->first();

            $games = Game::where('system_id', $system->id)->where('category_id', $category->id)->paginate(20);
        } else {
            $games = Game::where('system_id', $system->id)->paginate(20);
        }

        return view('game.index', ['games' => $games]);
    }
}
