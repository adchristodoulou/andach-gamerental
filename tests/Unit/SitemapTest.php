<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $response = $this->get('/sitemap');
        $response->assertSee('/test-page');
        $response->assertSee('/rent-test-game-in-stock');
        $response->assertSee('/plan/test-plan-2priority');
    }
}
