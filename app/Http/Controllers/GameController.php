<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use App\Rating;
use App\System;
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
        $this->validate($request, [
            'name' => 'required',
            'system_id' => 'required',
        ]);

        $game = Game::create($request->all());

        $game->picture_url = $request->picture->store('games_boxes', 'public');
        $game->thumb_url   = $request->picture->store('games_thumbs', 'public');
        $game->save();

        $request->session()->flash('success', 'Task was successful!');

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
        //
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
        //
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
