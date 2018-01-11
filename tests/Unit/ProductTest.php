<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_addToCart()
    {
        $response = $this->followingRedirects()->post('/product/addtocart', [
        	'product_id' => 1,
        	'quantity' => 1,
        	]);

        $response->assertSee('The product has been added to the cart');
        $response->assertSee('Name of the First Product');
    }

    public function test_cart()
    {
    	//All cart functions are tested in CartPurchaseTest
    	$this->assertTrue(true);
    }

    public function test_index()
    {
    	$response = $this->get('/product');
    	$response->assertSee('Name of the First Product');
    }

    public function test_show()
    {
    	$response = $this->get('/buy-test-first-product');
    	$response->assertSee('Name of the First Product');
    }

    public function test_showCategory()
    {
		$response = $this->get('/category-test-head-category');
    	$response->assertSee('Name of the First Product');
    }
}
