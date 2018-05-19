<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
