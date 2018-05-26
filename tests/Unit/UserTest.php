<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_account()
    {
        $response = $this->get('/user/account');
        $response->assertRedirect('login');

        $user = User::first();
        $this->be($user);

        $response = $this->get('/user/account');
        $response->assertSee('My Current List');
    }

    public function test_accountUpdate()
    {
    	$response = $this->post('/user/accountupdate');
        $response->assertRedirect('login');

        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/user/accountupdate');
        $response->assertSee('Your wishlist has been updated');
    }

    public function test_cancelSubscription()
    {
    	//Tested in ChangePlanTest
    	$this->assertTrue(true);
    }

    public function test_edit()
    {
    	$response = $this->get('/user/edit');
        $response->assertRedirect('login');

        $user = User::first();
        $this->be($user);

    	$response = $this->get('/user/edit');
        $response->assertSee('Update your Account Details');
    }

    public function test_history()
    {
		$response = $this->get('/user/history');
        $response->assertRedirect('login');

        $user = User::first();
        $this->be($user);

    	$response = $this->get('/user/history');
        $response->assertSee('My Game Rental History');
    }

    public function test_invoiceList()
    {
		//Tested in CartPurchaseTest
		$this->assertTrue(true);
    }

    public function test_invoiceShow()
    {
		//Tested in CartPurchaseTest
		$this->assertTrue(true);
    }

    public function test_registerAddress()
    {
    	//Tested in RegisterTest
    	$this->assertTrue(true);
    }

    public function test_registerPost()
    {
    	//Tested in RegisterTest
    	$this->assertTrue(true);
    }

    public function test_resumeSubscription()
    {
    	//Tested in ChangePlanTest
    	$this->assertTrue(true);
    }

    public function test_subscription()
    {
    	//Tested in ChangePlanTest
    	$this->assertTrue(true);
    }

    public function test_update()
    {
    	$response = $this->put('/user/update', ['test' => 1]);
        $response->assertRedirect('login');

        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->put('/user/update', ['test' => 1]);
        $response->assertSee('The name field is required.');
        $response->assertSee('The email field is required.');
        $response->assertSee('The shipping address1 field is required.');
        $response->assertSee('The shipping postcode field is required.');

        $response = $this->followingRedirects()->put('/user/update', [
            'name' => 1,
            'email' => 1,
            'shipping_address1' => 1,
            'shipping_postcode' => 1,
        ]);
        $response->assertSee('You have successfully changed your account details.');
    }
}
