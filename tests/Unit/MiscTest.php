<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MiscTest extends TestCase
{
    public function test_gtag()
    {
        $response = $this->get('/');
        $response->assertDontSee('gtag(\'set\', {\'user_id');

        $user = User::first();
        $this->be($user);

        $response = $this->get('/');
        $response->assertSee('gtag(\'set\', {\'user_id\': \'1\'});');
    }
}
