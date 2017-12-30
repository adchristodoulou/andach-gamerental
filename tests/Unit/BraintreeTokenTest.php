<?php

namespace Tests\Unit;

use App\Http\Controllers\BraintreeTokenController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BraintreeTokenTest extends TestCase
{
    protected $mainController;

    public function setUp() {
        parent::setUp();

        $this->mainController = $this->app->make(BraintreeTokenController::class);
    }

    public function testToken()
    {
        $token = $this->mainController->token();

        $this->assertTrue(isset($token));
    }
}
