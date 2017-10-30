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
        $games = Game::paginate(4);

        $systems = System::all()->pluck('name', 'url');
        $categories = Category::all()->pluck('name', 'url');
        $rating = Rating::all()->pluck('name', 'name');
        $premium = ['yes' => 'Only Premium', 'no' => 'Only Standard'];

        return view('game.index', ['games' => $games, 'systems' => $systems, 'ratings' => $rating, 'premium' => $premium, 'categories' => $categories]);
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
        $request->validate([
            'system_id' => 'required',
        ]);

        $game = Game::create($request->all());

        if(isset($request->picture))
        {
            dd($request->picture);
            $game->picture_url = $request->picture->store('games_boxes', 'public');
            $game->thumb_url   = $request->picture->store('games_thumbs', 'public');
        }
        $game->save();
        $game->refreshInfo();

        $request->session()->flash('success', 'The game has successfully been added, <a href="'.route('game.show', $game->slug).'">click here to see it</a>!');

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
        $game = Game::where('slug', $id)->first();

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
        $request->validate([
            'system_id' => 'required',
        ]);

        $game = Game::find($id);

        $game->update($request->all());

        if(isset($request->picture))
        {
            $game->picture_url = $request->picture->store('games_boxes', 'public');
            $game->thumb_url   = $request->picture->store('games_thumbs', 'public');
        }

        $game->save();
        $errors = $game->refreshInfo();

        if (count($errors))
        {
            $request->session()->flash('success', implode($errors, "\n"));

            return redirect()->route('game.edit', $id);
        }

        $request->session()->flash('success', 'The game has successfully been edited, <a href="'.route('game.show', $game->slug).'">click here to see it</a>!');

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
            $request->session()->flash('danger', 'You need to login to add a game to your wishlist!');
            return redirect()->route('login');
        }
        $game = Game::find($request->id);

        return redirect()->route('game.show', $game->slug);
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
        $game = Game::find($request->id);

        return redirect()->route('game.show', $game->slug);
    }

    public function homepage()
    {
        $xboxone = Game::where('system_id', 4920)->get()->random(4);
        $ps4     = Game::where('system_id', 4919)->get()->random(4);

        return view('home', ['xboxone' => $xboxone, 'ps4' => $ps4]);
    }

    public function search(Request $request)
    {
        $getString = str_replace('/rent-games/', '', $request->getPathInfo());
        //$getString = str_replace('/rent-games', '', $request->getPathInfo());

        $getArray = explode('~~', $getString);
        $getArray = array_filter($getArray);

        $where = array();

        foreach ($getArray as $line)
        {
            $keypair = explode('~', $line);

            $key   = $keypair[0];
            $value = $keypair[1];

            if ($key == 'rating_id')
            {
                $sqlvalue = implode(',', Rating::whereIn('name', explode(',', $value))->pluck('id')->toArray());

                $where[] = [$key, 'in', explode(',', $sqlvalue)];
            } else if ($key == 'num_available') {
                $where = ['num_available', '>', 0];
            } else if ($key == 'name') {
                $where[] = ['name', 'like', '%'.$value.'%'];
            } else {
                switch($key)
                {
                    case 'system_id':
                        $sqlvalue = System::where('url', $value)->first()->id;

                        $where[] = [$key, '=', $sqlvalue];
                    break;

                    case 'is_premium':
                        if ($value == 'yes')
                        {
                            $sqlvalue = 1;
                        } else {
                            $sqlvalue = 0;
                        }

                        $where[] = [$key, '=', $sqlvalue];
                    break;

                    case 'category_id':
                        $sqlvalue = Category::where('url', $value)->first()->id;

                        $where[] = [$key, '=', $sqlvalue];
                    break;
                }
            }
        }

        $games = Game::where($where)->paginate(20);

        $systems = System::all()->pluck('name', 'url');
        $categories = Category::all()->pluck('name', 'url');
        $rating = Rating::all()->pluck('name', 'name');
        $premium = ['yes' => 'Only Premium', 'no' => 'Only Standard'];

        return view('game.index', ['games' => $games, 'systems' => $systems, 'ratings' => $rating, 'premium' => $premium, 'categories' => $categories]);
    }

    //Accepts an array of GET variables and returns the SEO friendly searchSEO string, of the form
    // /rent-games/search/category|xbox360||
    public function searchPost(Request $request)
    {
        $vars = array();
        if (isset($request->name))
        {
            $vars[] = 'name~'.str_slug($request->name);
        }

        if (isset($request->system_id))
        {
            $vars[] = 'system_id~'.str_slug($request->system_id);
        }

        if (isset($request->is_available))
        {
            $vars[] = 'is_available~'.str_slug($request->is_available);
        }

        if (isset($request->is_premium))
        {
            $vars[] = 'is_premium~'.str_slug($request->is_premium);
        }

        if (isset($request->category_id))
        {
            $vars[] = 'category_id~'.str_slug($request->category_id);
        }

        if (isset($request->rating_id))
        {
            $ratingsArray = array_filter($request->rating_id);
            if (count($ratingsArray) > 0)
            {
                $vars[] = 'rating_id~'.implode(',', $ratingsArray);
            }
        }
        
        $getString = implode('~~', $vars);

        return redirect()->route('game.search', $getString);
    }
}
