<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_create()
    {
        $response = $this->get('/page/create');
        $response->assertStatus(302);

        $user = User::find(2);
        $this->be($user);

        $response = $this->get('/page/create');
        $response->assertStatus(302);

        $user = User::first();
        $this->be($user);
        
        $response = $this->get('/page/create');
        $response->assertSee('Create or Edit Page');
    }

    public function test_edit()
    {
        $response = $this->get('/page/1/edit');
        $response->assertStatus(302);

        $user = User::find(2);
        $this->be($user);

        $response = $this->get('/page/1/edit');
        $response->assertStatus(302);

        $user = User::first();
        $this->be($user);
        
        $response = $this->get('/page/1/edit');
        $response->assertSee('TEST BODY');
        $response->assertSee('TEST NAME');
        $response->assertSee('TEST H1');
        $response->assertSee('TEST HTMLTITLE');
        $response->assertSee('TEST METADESCRIPTION');
    }

    public function test_index()
    {
        $response = $this->get('/page');
        $response->assertStatus(302);

        $user = User::find(2);
        $this->be($user);

        $response = $this->get('/page');
        $response->assertStatus(302);

        $user = User::first();
        $this->be($user);
        
        $response = $this->get('/page');
        $response->assertSee('TEST H1');
        $response->assertSee('Pages Index');
    }

    public function test_show()
    {
        $response = $this->get('/test-page');
        $response->assertStatus(200);
        $response->assertSee('TEST BODY');
        $response->assertSee('TEST NAME');
        $response->assertSee('TEST H1');
        $response->assertSee('TEST HTMLTITLE');
        $response->assertSee('TEST METADESCRIPTION');

        $response = $this->get('/doesnt-exist');
        $response->assertStatus(404);
    }

    public function test_store()
    {
        $response = $this->post('/page', ['slug' => 'x']);
        $response->assertStatus(302);

        $user = User::find(2);
        $this->be($user);

        $response = $this->post('/page', ['slug' => 'x']);
        $response->assertStatus(302);

        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/page', [
            'slug' => 'x',
            'name' => 'x',
            'h1' => 'x',
            'html_title' => 'x',
            'meta_description' => 'x',
            'body' => 'x',
        ]);
        $response->assertSee('The page has successfully been added');
    }

    public function test_update()
    {
        $response = $this->put('/page/1', ['slug' => 'x']);
        $response->assertStatus(302);

        $user = User::find(2);
        $this->be($user);

        $response = $this->put('/page/1', ['slug' => 'x']);
        $response->assertStatus(302);

        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->put('/page/1', [
            'slug' => 'x1',
            'name' => 'x2',
            'h1' => 'x3',
            'html_title' => 'x4',
            'meta_description' => 'x5',
            'body' => 'x6',
        ]);
        $response->assertSee('The page has successfully been edited');

        $response = $this->get('/x1');
        $response->assertSee('<li class="breadcrumb-item active">x2</li>');
        $response->assertSee('<h1>x3</h1>');
        $response->assertSee('<title>x4</title>');
        $response->assertSee('<meta property="og:description" content="x5" />');
        $response->assertSee('x6');
    }
}
