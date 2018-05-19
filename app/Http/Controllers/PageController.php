<?php

namespace App\Http\Controllers;

use App\Game;
use App\Page;
use Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkadmin', ['except' => ['show', 'addComment']]);
    }
    
    public function addComment(Request $request)
    {
        $page = Page::find($request->id);

        if (!$page) 
        {
            session()->flash('danger', 'Invalid page.');
            return redirect()->route('home');
        }
        
        if (!Auth::check())
        {
            session()->flash('danger', 'You need to be logged in to comment on a page.');
            return redirect()->route('page.show', ['id' => $page->slug]);
        }
        
        if ($page->canComment())
        {
            $add['user_id'] = Auth::id();
            $add['comment'] = $request->comment;
            $page->comments()->create($add);
            session()->flash('success', 'Your comment has been added.');
        } else {
            session()->flash('danger', 'You cannot comment on this page.');
        }
        
        return redirect()->route('page.show', ['id' => $page->slug]);
    }
    
    public function create()
    {
        $games = Game::all()->pluck('slug_name', 'id');
        
        return view('page.form', ['games' => $games]);
    }

    public function edit($id)
    {
        $page = Page::find($id);
        $games = Game::all()->pluck('slug_name', 'id');

        return view('page.form', ['page' => $page, 'games' => $games]);
    }

    public function index()
    {
        $pages = Page::all();

        return view('page.index', ['pages' => $pages]);
    }

    public function show($id)
    {
        //Synchronise with GameController@show
        $page = Page::where('slug', $id)->first();

        if (!$page) 
        {
            abort(404, 'Page not found');
        }

        return view('page.show', ['page' => $page]);
    }

    public function store(Request $request)
    {
        $page = Page::create($request->all());
        $page->author_id = Auth::id();
        $page->save();

        $request->session()->flash('success', 'The page has successfully been added, <a href="'.route('page.show', $page->slug).'">click here to see it</a>!');

        return redirect()->route('page.create');
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);
        $update = $request->all();
        
        if (!isset($update['is_commentable']))
        {
            $update['is_commentable'] = 0;
        }
        $page->update($update);
        $page->save();

        $request->session()->flash('success', 'The page has successfully been edited, <a href="'.route('page.show', $page->slug).'">click here to see it</a>!');

        return redirect()->route('page.edit', $id);
    }
}
