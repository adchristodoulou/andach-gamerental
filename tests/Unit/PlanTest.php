<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $response = $this->get('/plan');
        $response->assertSee('TEST PLAN 1PERMONTH');
        $response->assertSee('TEST PLAN 1UNLIMITED');
        $response->assertSee('TEST PLAN 2PRIORITY');
        $response->assertSee('TEST PLAN 3UNLIMITED');
    }

    public function test_show()
    {
        $response = $this->get('/plan/test-plan-1permonth');
        $response->assertSee('TEST PLAN 1PERMONTH');

    }

    public function test_store()
    {
    	//Tested in ChangePlanTest and RegisterTest
    	$this->assertTrue(true);
    }
}
