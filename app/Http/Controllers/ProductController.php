<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Invoice;
use App\Product;
use Auth;
use Transaction;
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
		$prices = Cart::priceFromLines($cartLines);
		
		return view('product.cart', ['cartLines' => $cartLines, 'prices' => $prices]);
	}

	public function cart2()
	{
		$cartLines = Cart::myCart();
		$prices = Cart::priceFromLines($cartLines);
		
		return view('product.cart2', ['cartLines' => $cartLines, 'prices' => $prices]);
	}

	public function cart3(Request $request)
	{
		$cartLines = Cart::myCart();
		$prices = Cart::priceFromLines($cartLines);
		$array = ['name', 'email', 'phone', 'shipping_address1', 'shipping_address2', 'shipping_address3', 'shipping_town', 'shipping_county', 'shipping_postcode'];
		
		return view('product.cart3', ['cartLines' => $cartLines, 'prices' => $prices, 'request' => $request->all(), 'fields' => $array]);
	}

	public function cart4(Request $request)
	{
		//TODO ACTUALLY DO THIS IT DOESNT EVEN VAGUELY WORK
		$result = \Braintree\Transaction::sale([
		    'amount' => $request->total,
		    'paymentMethodNonce' => $request->nonce,
		    'options' => [
		        'submitForSettlement' => true
		    ]
		]);
		if ($result->success || !is_null($result->transaction) || true) {
		    $transaction = $result->transaction;

		    $prices = Cart::priceFromLines();
		    
    		$invoice = Invoice::create($request->all());
    		$invoice->user_id = Auth::id();
    		//$invoice->billing_postcode = $transaction->billingDetails->postalCode;
    		//$invoice->braintree_amount = $transaction->amount;
    		//$invoice->braintree_authcode = $transaction->processorAuthorizationCode;
    		$invoice->importCart();
    		$invoice->setShippingGrossInPounds($prices['shipping']);
    		$invoice->finalise();
	    	$invoice->save();

	    	//Cart::empty();

	    	return view('product.cart4', ['invoice' => $invoice, 'transaction' => $transaction]);
		} else {
		    $errorString = "";
		    foreach($result->errors->deepAll() as $error) {
		        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
		    }
		    
		    session()->flash('danger', 'There has been an error: '.$errorString);

		    return redirect()->route('product.cart2');
		}
	}

	public function cartPost(Request $request)
	{
		$cartLines = Cart::myCart();

		foreach ($cartLines as $line)
		{
			if (isset($request->cartQuantity[$line->id]))
			{
				$line->setQuantity($request->cartQuantity[$line->id]);
			}
		}

		session()->flash('success', 'Quantities in the cart have been updated.');

		return redirect()->route('product.cart');
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
