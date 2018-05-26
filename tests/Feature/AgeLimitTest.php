<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgeLimitTest extends TestCase
{
	use RefreshDatabase;
    
    public function test_feature()
    {
        $user = User::find(1);
        $this->be($user);
        
        $response = $this->followingRedirects()->post('/user/agelimitupdate', ['age' => 7]);
        $response->assertSee('Please click the link in your email to confirm');
        
        $hash = $user->maximum_age_hash;
        
        $response = $this->followingRedirects()->get('/user/agelimitconfirm/x');
        $response->assertSee('Your code was not recognised');
        
        $response = $this->followingRedirects()->get('user/agelimitconfirm/'.$hash);
        $response->assertSee('Your new age limit has been confirmed');
    }
}
