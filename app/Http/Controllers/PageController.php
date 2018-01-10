<?php

namespace App\Http\Controllers;

use App\Page;
use Auth;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkadmin', ['except' => 'show']);
    }
    
    public function create()
    {
        return view('page.form');
    }

    public function edit($id)
    {
        $page = Page::find($id);

        return view('page.form', ['page' => $page]);
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

        if (!$page) abort(404, 'Page not found');

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
        $page->update($request->all());
        $page->save();

        $request->session()->flash('success', 'The page has successfully been edited, <a href="'.route('page.show', $page->slug).'">click here to see it</a>!');

        return redirect()->route('page.edit', $id);
    }
}
