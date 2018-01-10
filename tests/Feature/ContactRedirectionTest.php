<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactRedirectionTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminUserCanSee()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/contact');
        $response->assertStatus(200);

        $response = $this->get('/contact/show/1');
        $response->assertStatus(200);

        $response = $this->get('/contact/show/2');
        $response->assertStatus(200);
    }

    public function testNoUserCantSee()
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);

        $response = $this->get('/contact/show/1');
        $response->assertStatus(302); 
    }

    public function testOtherUserCantSee()
    {
        $user = User::find(2);
        $this->be($user);

        $response = $this->get('/contact');
        $response->assertStatus(200);

        //User should be able to see their own request. 
        $response = $this->get('/contact/show/1');
        $response->assertStatus(200); 

        //User should not be able to see someone else's contact request.
        $response = $this->get('/contact/show/2');
        $response->assertStatus(302); 
    }
}
