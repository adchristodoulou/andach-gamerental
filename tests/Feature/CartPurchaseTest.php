<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartPurchaseTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_feature()
    {
        $response = $this->followingRedirects()->post('/product/addtocart', [
        	'product_id' => 1,
        	'quantity' => 1,
        ]);
        $response->assertSee('The product has been added to the cart');

        $response = $this->get('/cart');
        $response->assertSee('<div class="col-2">&pound;9.99</div>');
        $response->assertSee('<div class="col-2">&pound;1.99</div>');

        $response = $this->get('/cart2');
        $response->assertSee('You aren\'t logged in');
        $response->assertSee('&pound;1.99');
        $response->assertSee('<div class="card-footer">Total Price: &pound;11.98</div>');

        //Now change the quantity. 
        $response = $this->followingRedirects()->post('/cart', [
        	'cartQuantity' => [1 => 3],
        ]);
        $response->assertSee('Quantities in the cart have been updated');
        $response->assertSee('<div class="col-2">&pound;9.99</div>');
        $response->assertSee('<div class="col-2">&pound;0.00</div>');
        $response->assertSee('<div class="col-2">&pound;29.97</div>');
        $response->assertDontSee('<div class="col-2">&pound;1.99</div>');

        $response = $this->get('/cart2');
        $response->assertSee('You aren\'t logged in');
        $response->assertDontSee('&pound;1.99');
        $response->assertSee('<div class="card-footer">Total Price: &pound;29.97</div>');

        $user = User::find(1);
        $this->be($user);

        $response = $this->get('/cart');
        $response->assertDontSee('You aren\'t logged in');
        $response->assertDontSee('&pound;1.99');
        $response->assertSee('<div class="card-footer">Total Price: &pound;29.97</div>');
        $response->assertSee('Admin User');
        $response->assertSee('admin@example.com');

        $response = $this->post('/cart3' []);
        $response->assertSee('The name field is required.');
        $response->assertSee('The email field is required.');
        $response->assertSee('The shipping address1 field is required.');
        $response->assertSee('The shipping postcode field is required.');

        $response = $this->post('/cart3', [
        	'name' => 'Admin User',
        	'email' => 'admin@example.com',
        	'shipping_address1' => '123 Test Street',
        	'shipping_postcode' => 'AB12 3CD',
        ]);
        $response->assertDontSee('The name field is required.');
        $response->assertDontSee('The email field is required.');
        $response->assertDontSee('The shipping address1 field is required.');
        $response->assertDontSee('The shipping postcode field is required.');
        $response->assertSee('Step 3 of 4');


    }
}
