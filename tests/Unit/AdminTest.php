<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testAdminUserCanSee()
    {
    	$this->assertTrue(true);
    }

    public function testNoUserCantSee()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('login');

        $response = $this->post('/admin/assignment-run');
        $response->assertRedirect('login');    
    }
}
