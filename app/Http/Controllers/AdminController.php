<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\AssignmentRun;
use App\Game;
use App\Rental;
use App\RetirementReason;
use App\Stock;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkadmin');
    }

    public function admin()
    {
        return view('admin.admin');
    }

    public function assignmentRun(Request $request)
    {
        $run = new AssignmentRun;
        $run->user_id = Auth::id();
        $run->date_of_run = date('Y-m-d');
        $run->save();

        $run->makeAssignments();

        return redirect()->route('admin.sendgames');
    }

    public function confirmAssignments(Request $request)
    {
        if (count($request->assign))
        {
            foreach ($request->assign as $assign)
            {
                $assignment = Assignment::find($assign);
                $assignment->makeIntoRental();
            }
        }

        if (count($request->deliver))
        {
            foreach ($request->deliver as $delivery)
            {
                $assignment = Assignment::find($delivery);
                $assignment->deliver();
            }
        }

        return redirect()->route('admin.sendgames');
    }

    public function printDeliveryNote($assignmentID)
    {
        $assignment = Assignment::find($assignmentID);

        return view('admin.printdeliverynote', ['assignment' => $assignment]);
    }

    public function rentals()
    {
        $rentals = Rental::whereNull('date_of_return')->get();

        return view('admin.rentals', ['rentals' => $rentals]);
    }

    public function rentalsUpdate(Request $request)
    {
        if (count($request->rentals))
        {
            foreach ($request->rentals as $rentalID)
            {
                $rental = Rental::find($rentalID);
                $rental->markAsPosted();
            }
        }

        return redirect()->route('admin.rentals');
    }

    public function sendGames()
    {
        $runs = AssignmentRun::where('date_of_run', date('Y-m-d'))->get();

        return view('admin.sendgames', ['runs' => $runs]);
    }

    public function stock($id)
    {
        $game = Game::find($id);

        $reasons = RetirementReason::all()->pluck('name', 'id');
    
    	return view('admin.stock', ['game' => $game, 'reasons' => $reasons]);
    }

    public function stockIndex()
    {
        $stocks = Stock::all();

        return view('admin.stockindex', ['stocks' => $stocks]);
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
