<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('login');

        $response = $this->post('/admin/assignment-run');
        $response->assertRedirect('login');        
    }
}
