<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\AssignmentRun;
use App\Competitor;
use App\CompetitorListing;
use App\Game;
use App\Product;
use App\ProductCategory;
use App\ProductPicture;
use App\Rental;
use App\RetirementReason;
use App\Stock;
use App\User;
use Auth;
use Excel;
use IGDB;
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

    public function competitors()
    {
        $competitors = Competitor::all();
        $products    = Product::pluck('name', 'id');
        $games       = Game::pluck('name', 'id');

        return view('admin.competitors', ['competitors' => $competitors, 'products' => $products, 'games' => $games]);
    }

    public function competitorsPost(Request $request)
    {
        if ($request->competitor_id)
        {
            CompetitorListing::create($request->all());

            $request->session()->flash('success', 'The Listing has been added');
        }

        if (count($request->listingUpdate))
        {
            $ids = $request->listingUpdate;

            foreach ($ids as $id)
            {
                $listing = CompetitorListing::find($id);
                $listing->updatePrice();
            }
        }

        return redirect()->route('admin.competitors');
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

    public function gameIndex()
    {
        $games = Game::all();

        return view('admin.gameindex', ['games' => $games]);
    }

    public function gameIndexPost(Request $request)
    {
        if (count($request->games))
        {
            foreach ($request->games as $gameID)
            {
                $game = Game::find($gameID);

                $game->refreshInfo();
            }
        }

        $request->session()->flash('success', 'Games have been successfully updated!');

        return redirect()->route('admin.gameindex');
    }

    public function IGDBSearch($name)
    {
        $api = IGDB::searchGames($name);
        foreach ($api as $game)
        {
            $return[] = $game->id.' - '.$game->name;
        }

        return '<pre>'.print_r($return, 1).'</pre>';
    }

    public function printDeliveryNote($assignmentID)
    {
        $assignment = Assignment::find($assignmentID);

        return view('admin.printdeliverynote', ['assignment' => $assignment]);
    }

    public function productCreate()
    {
        $games = Game::pluck('name', 'id');
        $categories = ProductCategory::pluck('name', 'id');

        return view('admin.productform', ['games' => $games, 'categories' => $categories]);
    }

    public function productEdit($id)
    {
        $product = Product::find($id);
        $games = Game::pluck('name', 'id');
        $categories = ProductCategory::pluck('name', 'id');

        return view('admin.productform', ['product' => $product, 'games' => $games, 'categories' => $categories]);
    }

    public function productIndex()
    {
        $products = Product::with('pictures')->get();

        return view('admin.productindex', ['products' => $products]);
    }

    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'slug' => 'required',
        ]);

        $product = Product::create($request->all());

        if (count($request->uploadpictures))
        {
            foreach ($request->uploadpictures as $picture) 
            {
                $product->addPicture($picture);
            }
        }
        
        $product->save();
        $product->addCategory($request->add_category);

        $request->session()->flash('success', 'The product has been created.');

        return redirect()->route('admin.productindex');
    }

    public function productUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'slug' => 'required',
        ]);

        $product = Product::find($request->id);

        $product->update($request->all());
        $product->addCategory($request->add_category);

        if (count($request->uploadpictures))
        {
            foreach ($request->uploadpictures as $picture) 
            {
                $product->addPicture($picture);
            }
        }

        if (count($request->pictures))
        {
            foreach ($request->pictures as $pictureID)
            {
                $picture = ProductPicture::find($pictureID);
                $picture->setMain($pictureID == $request->is_main);
            }
        }

        if (count($request->deleteCat))
        {
            foreach ($request->deleteCat as $catID)
            {
                $product->deleteCategory($catID);
            }
        }

        if (count($request->deleteImage))
        {
            foreach ($request->deleteImage as $pictureID)
            {
                $picture = ProductPicture::find($pictureID);
                $picture->deleteImages();
                $picture->delete();

            }
        }

        $request->session()->flash('success', 'The product has been edited.');

        return redirect()->route('admin.productedit', $request->id);
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
                $rental->markAsReceived();
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
            $request->session()->flash('success', 'The stock has successfully been retired!');
            $returnID = $stock->game_id;
        }

        return redirect()->route('admin.stock', $returnID);
    }

    public function uploadStock()
    {
        return view('admin.uploadstock');
    }

    public function uploadStockPost(Request $request)
    {
        $file = $request->file('csv');

        $excel = Excel::load($file->path())->toArray();

        $count = 0;
        foreach ($excel as $line)
        {
            $game = Game::create([
                    'gamesdb_id' => $line['gamesdb_id'],
                    'xbox_id' => $line['xbox_id'],
                    'system_id' => $line['system_id'],
                ]);
            $game->save();

            $count++;
        }

        $request->session()->flash('success', $count.' games have been successfully uploaded. You might want to go to <a href="'.route('admin.gameindex').'">the game index page to update these immediately.');

        return redirect()->route('admin.uploadstock');
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
