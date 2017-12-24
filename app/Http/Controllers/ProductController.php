<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function addToCart(Request $request)
	{
		$product = Product::find($request->product_id);
		$product->addToCart($request->quantity);

		$request->session()->flash('success', 'The product has been added to the cart');

		return redirect()->route('product.show', $product->slug);
	}

	public function cart()
	{
		$cartLines = Cart::myCart();
		
		return view('product.cart', ['cartLines' => $cartLines]);
	}

    public function index()
    {
    	$products = Product::all();

    	return view('product.index', ['products' => $products]);
    }

    public function show($slug)
    {
    	$product = Product::where('slug', $slug)->first();

    	return view('product.show', ['product' => $product]);
    }
}
