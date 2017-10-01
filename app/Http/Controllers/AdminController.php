<?php

namespace App\Http\Controllers;

use App\Game;
use App\RetirementReason;
use App\Stock;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function sendGames()
    {
        return view('admin.sendgames');
    }

    public function stock($id)
    {
        $game = Game::find($id);

        $reasons = RetirementReason::all()->pluck('name', 'id');
    
    	return view('admin.stock', ['game' => $game, 'reasons' => $reasons]);
    }

    public function stockUpdate(Request $request)
    {
        if ($request->game_id)
        {
            Stock::create($request->all());
            $game = Game::find($request->game_id);
            $game->incrementStock(1);

            $request->session()->flash('success', 'The stock has successfully been updated!');
            $returnID = $request->game_id;
        } else {
            foreach ($request->retire as $stockid)
            {
                $stock = Stock::find($stockid);
                $stock->retire($request->retirement_reason_id);
            }
            $returnID = $stock->game_id;
        }

        return redirect()->route('admin.stock', $returnID);
    }
}
