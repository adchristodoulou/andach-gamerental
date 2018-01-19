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
