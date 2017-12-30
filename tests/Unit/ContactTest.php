<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicRoutes()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contact Andach');
    }
}
