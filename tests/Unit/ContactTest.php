<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use NoCaptcha;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_attachment()
    {
        //Test in AssignmentRunTest
        $this->assertTrue(true);
    }
    
    public function test_create()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contact Andach');
        $response->assertSee('<!-- Showing Captcha -->');
        $response->assertDontSee('You are currently logged in');

        $user = User::first();
        $this->be($user);

        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('Contact Andach');
        $response->assertDontSee('<!-- Showing Captcha -->');
        $response->assertSee('You are currently logged in');
    }

    public function test_show()
    {
    	$user = User::first();
        $this->be($user);

    	$response = $this->get('/contact/show/1');

    	$response->assertStatus(200);
    	$response->assertSee('CONTACT TITLE');
    	$response->assertSee('CONTACT FULLTEXT');
    }

    public function test_store()
    {
        // prevent validation error on captcha
        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);
    
    	$response = $this->followingRedirects()->post('/contact/send', [
            'title' => 'CONTACTINSERT TITLE',
    		'category_id' => 1,
    		'full_text' => 'CONTACTINSERT FULL TEXT',
    		]);
        $response->assertSee('email field is required');

        $response = $this->followingRedirects()->post('/contact/send', [
            'email' => 'invalid',
            'category_id' => 1,
            ]);
        $response->assertSee('email must be a valid email address');
        $response->assertSee('title field is required');
        $response->assertSee('full text field is required');
        $response->assertSee('g-recaptcha-response field is required');

        $response = $this->followingRedirects()->post('/contact/send', [
            'title' => 'CONTACTINSERT TITLE',
            'email' => 'test@example.com',
            'category_id' => 1,
            'g-recaptcha-response' => '1',
            'full_text' => 'CONTACTINSERT FULL TEXT',
            ]);
        $response->assertSee('Thankyou, we have received your comments');
    }

    public function test_store_logged_in()
    {
        //Now check these all work when logged in. 
        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/contact/send', [
            'category_id' => 1,
            ]);
        $response->assertSee('title field is required');
        $response->assertSee('full text field is required');

        $response = $this->followingRedirects()->post('/contact/send', [
            'title' => 'CONTACTINSERT TITLE',
            'category_id' => 1,
            'full_text' => 'CONTACTINSERT FULL TEXT',
            ]);
        $response->assertSee('Thankyou, we have received your comments');
    }

    public function test_update()
    {
    	$user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/contact/send', [
    		'id' => 1,
    		'full_text' => 'CONTACTUPDATE FULL TEXT',
    		]);

    	$response->assertSee('Your reply has been logged');
    }
}
