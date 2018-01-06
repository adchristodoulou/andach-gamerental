<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function testPageExists()
    {
        $response = $this->get('/test-page');

        $response->assertStatus(200);
        $response->assertSee('TEST BODY');
        $response->assertSee('TEST NAME');
        $response->assertSee('TEST H1');
        $response->assertSee('TEST HTMLTITLE');
        $response->assertSee('TEST METADESCRIPTION');
    }

    public function testPageDoesntExist()
    {
        $response = $this->get('/doesnt-exist');

        $response->assertStatus(404);
    }
}
