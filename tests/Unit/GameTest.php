<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameTest extends TestCase
{
    use RefreshDatabase;

    public function test_achievements()
    {
        //Not yet tested. This isn't live yet and needs significant work. 
        $this->assertTrue(true);
    }

    public function test_addToWishlist()
    {
        $response = $this->followingRedirects()->post('/game/addtowishlist', [
            'id' => 1,
            ]);
        $response->assertSee('You need to login to add a game to your wishlist');

        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/game/addtowishlist', [
            'id' => 1,
            ]);
        $response->assertSee('This game has been added to your wishlist');

        $response = $this->followingRedirects()->get('/user/account');
        $response->assertSee('TEST GAME IN STOCK');
    }

    public function test_create()
    {
        $response = $this->get('/game/create');
        $response->assertStatus(302);

        $user = User::find(2);
        $this->be($user);

        $response = $this->get('/game/create');
        $response->assertStatus(302);

        $user = User::first();
        $this->be($user);
        
        $response = $this->get('/game/create');
        $response->assertSee('Create or Edit Game');
    }

    public function test_deleteFromWishlist()
    {
        $response = $this->followingRedirects()->post('/game/deletefromwishlist', [
            'id' => 1,
            ]);
        $response->assertSee('You need to login to delete a game to your wishlist');

        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/game/deletefromwishlist', [
            'id' => 1,
            ]);
        $response->assertSee('on your wishlist in the first place');
    }

    public function test_edit()
    {
        $response = $this->get('/game/1/edit');
        $response->assertStatus(302);

        $user = User::find(2);
        $this->be($user);

        $response = $this->get('/game/1/edit');
        $response->assertStatus(302);

        $user = User::first();
        $this->be($user);
        
        $response = $this->get('/game/1/edit');
        $response->assertSee('Create or Edit Game');
        $response->assertSee('TEST GAME IN STOCK');
    }

    public function test_homepage()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_index()
    {
        $response = $this->get('/game');
        $response->assertStatus(200);
        $response->assertSee('TEST GAME IN STOCK');
        $response->assertSee('TEST GAME OUT OF STOCK');
    }

    public function test_search()
    {
        $response = $this->get('/search-games');
        $response->assertStatus(200);
        $response->assertSee('TEST GAME IN STOCK');
        $response->assertSee('TEST GAME OUT OF STOCK');

        //Search just for xbox one
        $response = $this->get('/search-games?name=&system_id=xbox-one');
        $response->assertStatus(200);
        $response->assertSee('TEST GAME IN STOCK');
        $response->assertDontSee('TEST GAME OUT OF STOCK');

        //Search just for PS4
        $response = $this->get('/search-games?name=&system_id=ps4');
        $response->assertStatus(200);
        $response->assertDontSee('TEST GAME IN STOCK');
        $response->assertSee('TEST GAME OUT OF STOCK');

        //Search just for PS4
        $response = $this->get('/search-games?name=&num_available=1');
        $response->assertStatus(200);
        $response->assertSee('TEST GAME IN STOCK');
        $response->assertDontSee('TEST GAME OUT OF STOCK');
    }

    public function test_show()
    {
        $response = $this->get('/rent-test-game-in-stock');

        $response->assertStatus(200);
        $response->assertSee('TEST GAME IN STOCK');
    }

    public function test_store()
    {
        $response = $this->post('/game', ['name' => 'final fantasy 7']);
        $response->assertStatus(302);

        $user = User::find(2);
        $this->be($user);

        $response = $this->post('/game', ['name' => 'final fantasy 7']);
        $response->assertStatus(302);

        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->post('/game', ['name' => 'final fantasy 7']);
        $response->assertSee('427 - Final Fantasy VII');

        $response = $this->followingRedirects()->post('/game', [
            'gamesdb_id' => 427,
            'system_id' => 10,
        ]);
        $response->assertSee('The game has successfully been added');
    }

    public function test_update()
    {
        $response = $this->put('/game/1', ['name' => 'x']);
        $response->assertStatus(302);

        $user = User::find(2);
        $this->be($user);

        $response = $this->put('/game/1', ['name' => 'x']);
        $response->assertStatus(302);

        $user = User::first();
        $this->be($user);

        $response = $this->followingRedirects()->put('/game/1', [
            'gamesdb_id' => 427,
            'system_id' => 10,
        ]);
        $response->assertSee('The game has successfully been edited');
    }
}
