<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->followingRedirects()->post('/register', []);
        $response->assertSee('The name field is required.');
        $response->assertSee('The email field is required.');
        $response->assertSee('The password field is required.');

        $response = $this->followingRedirects()->post('/register', [
            'name' => 'John Smith',
            'email' => 'admin@example.com',
            'password' => 'letmein',
        ]);
        $response->assertDontSee('The name field is required.');
        $response->assertSee('The email has already been taken.');
        $response->assertSee('The password confirmation does not match.');


        $response = $this->followingRedirects()->post('/register', [
        	'name' => 'John Smith',
        	'email' => 'johnsmith@example.com',
        	'password' => 'letmein',
        	'password_confirmation' => 'letmein',
        ]);

        $response->assertSee('User Registration (Step 2 of 3 - Address)');

        $response = $this->followingRedirects()->post('/user/register', [
        	'shipping_address1' => 'test1',
        	'shipping_postcode' => 'testpostcode',
        ]);
        $response->assertSee('You have successfully added your address details. Now choose your plan');
    }
}
