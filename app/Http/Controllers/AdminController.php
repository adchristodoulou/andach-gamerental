<?php

namespace App\Http\Controllers;

use App\Game;
use App\RetirementReason;
use App\Stock;
use App\User;
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

    public function users(Request $request)
    {
        if ($request->name) $where[] = ['name', 'LIKE', '%'.$request->name.'%'];
        if ($request->email) $where[] = ['email', 'LIKE', '%'.$request->email.'%'];
        if ($request->billing_postcode) $where[] = ['billing_postcode', 'LIKE', '%'.$request->billing_postcode.'%'];
        if ($request->shipping_postcode) $where[] = ['shipping_postcode', 'LIKE', '%'.$request->shipping_postcode.'%'];

        if (isset($where))
        {
            $users = User::where($where)->paginate(20);
        } else {
            $users = User::paginate(20);
        }
        

        return view('admin.users', ['users' => $users]);
    }
}
