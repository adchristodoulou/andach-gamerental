<?php

namespace App\Http\Controllers;

use App\Game;
use App\Stock;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function sendGames()
    {
        return view('admin.sendgames');
    }

    public function stock()
    {
    	$games = Game::all()->pluck('name', 'id');

    	return view('admin.stock', ['games' => $games]);
    }

    public function stockUpdate(Request $request)
    {
    	Stock::create($request->all());

        $request->session()->flash('success', 'The stock has successfully been updated!');

        return redirect()->route('admin.stock');
    }
}
