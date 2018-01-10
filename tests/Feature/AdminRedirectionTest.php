<?php

namespace Tests\Feature;

use App\System;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminRedirectionTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminUserCanSee()
    {
        $user = User::first();
        $this->be($user);

        $response = $this->get('/admin');
        $response->assertSee('ADMIN DASHBOARD');

        $response = $this->post('/admin/send-games');
        $response->assertSee('Assignment Run');
    }

    public function testNoUserCantSee()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('login');

        $response = $this->post('/admin/assignment-run');
        $response->assertRedirect('login');    
    }

    public function testOtherUserCantSee()
    {
        $user = User::find(2);
        $this->be($user);

        $response = $this->get('/admin');
        $response->assertStatus(302);
    }
}
