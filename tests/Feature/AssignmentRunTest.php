<?php

namespace Tests\Feature;

use App\Subscription;
use App\User;
use Braintree\PaymentMethodNonce;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignmentRunTest extends TestCase
{
	use RefreshDatabase;

    //Note that Game ID 1 and 4 both have 1 in stock, game ID 3 and 5 have 2 in stock. No stock of any other games in the test database seed. 

    public function test_feature()
    {
        /*
        $user1 = User::find(1);
        $user2 = User::find(2);

        //User 1 adds games to their list. 
        $this->be($user1);
        $response = $this->followingRedirects()->post('/game/addtowishlist', ['id' => 1]);
        $response = $this->followingRedirects()->post('/game/addtowishlist', ['id' => 3]);
        $response = $this->followingRedirects()->post('/game/addtowishlist', ['id' => 5]);

        $response = $this->get('/user/account');
        $response->assertSee('TEST GAME IN STOCK');
        $response->assertSee('TEST GAME XboxOne 2');

        $response = $this->get('/user/subscription');
        $response->assertSee('TEST PLAN 1PERMONTH');

        //User 2 adds games to their list.
        $this->be($user2);
        $response = $this->followingRedirects()->post('/game/addtowishlist', ['id' => 1]);
        $response = $this->followingRedirects()->post('/game/addtowishlist', ['id' => 2]);
        $response = $this->followingRedirects()->post('/game/addtowishlist', ['id' => 3]);
        $response = $this->followingRedirects()->post('/game/addtowishlist', ['id' => 4]);

        $response = $this->get('/user/account');
        $response->assertSee('TEST GAME IN STOCK');
        $response->assertSee('TEST GAME OUT OF STOCK');
        $response->assertSee('TEST GAME XboxOne 2');

        $response = $this->get('/user/subscription');
        $response->assertSee('TEST PLAN 2PRIORITY');

        //Admin runs allocation. Test that User 2 gets theirs as priority. Test that out of stock games aren't allocated. 
        $this->be($user1);
        $response = $this->followingRedirects()->post('/admin/assignment-run');
        $response->assertSee('<!-- Normal User gets TEST GAME IN STOCK -->');
        $response->assertSee('<!-- Normal User gets TEST GAME XboxOne 2 -->');
        $response->assertSee('<!-- Admin User gets TEST GAME XboxOne 2 -->');
        $response->assertSee('<input name="assign[]" type="checkbox" value="1">');
        $response->assertSee('<input name="assign[]" type="checkbox" value="2">');
        $response->assertSee('<input name="assign[]" type="checkbox" value="3">');

        $response = $this->get('/admin/rentals');
        $response->assertDontSee('TEST GAME IN STOCK');
        $response->assertDontSee('TEST GAME XboxOne 2');

        //Admin confirms the assignment of games. 
        $response = $this->followingRedirects()->post('/admin/confirm-assignments', [
            'assign' => [1, 2, 3],
            ]);
        $response->assertDontSee('<input name="assign[]" type="checkbox" value="1">');
        $response->assertDontSee('<input name="assign[]" type="checkbox" value="2">');
        $response->assertDontSee('<input name="assign[]" type="checkbox" value="3">');

        $response = $this->get('/admin/rentals');
        $response->assertSee('TEST GAME IN STOCK');
        $response->assertSee('TEST GAME XboxOne 2');
        $response->assertDontSee('<input type="checkbox"');

        //Admin confirms the delivery of games. 
        $response = $this->followingRedirects()->post('/admin/confirm-assignments', [
            'deliver' => [1, 2, 3],
            ]);
        $response->assertSee(date('Y-m-d'));
        $response->assertDontSee('Not yet assigned');

        $response = $this->get('/admin/rentals');
        $response->assertSee('TEST GAME IN STOCK');
        $response->assertSee('TEST GAME XboxOne 2');
        $response->assertSee('<input name="rentals[]" type="checkbox"');

        //User 1 returns a game, and User 2 returns one of their games. Test stock affected correctly. 
        $response = $this->followingRedirects()->post('/admin/rentals-update', [
            'rentals' => [1, 3],
            ]);
        $response->assertSee('<input name="rentals[]" type="checkbox" value="2">');
        $response->assertDontSee('<input name="rentals[]" type="checkbox" value="1">');
        $response->assertDontSee('<input name="rentals[]" type="checkbox" value="3">');

        //Admin runs allocation. Test that User 2 gets one game, User 1 gets nothing. 
        $response = $this->followingRedirects()->post('/admin/assignment-run');
        $response->assertSee('Assignment run #2');
        $response->assertSee('<!-- Normal User gets TEST GAME XboxOne 3 -->');
        $response->assertSee('<!-- Normal User on run #1 -->');
        $response->assertDontSee('<!-- Admin User on run #2 -->');
        */
    }
}
