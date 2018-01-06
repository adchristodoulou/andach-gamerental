<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameTest extends TestCase
{
    use RefreshDatabase;
    public function testSearchExists()
    {
        $response = $this->get('/search-games');

        $response->assertStatus(200);
        $response->assertSee('Games Index');
        $response->assertSee('TEST GAME');
    }

    public function testGameExists()
    {
        $response = $this->get('/rent-test-game');

        $response->assertStatus(200);
        $response->assertSee('TEST GAME');
    }
}
