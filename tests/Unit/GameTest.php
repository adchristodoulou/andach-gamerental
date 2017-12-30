<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicRoutes()
    {
        $response = $this->get('/search-games');

        $response->assertStatus(200);
        $response->assertSee('Games Index');

        $response = $this->get('/rent-halo-5-guardians-xbox-one');

        $response->assertStatus(200);
        $response->assertSee('Rent Halo');


    }
}
