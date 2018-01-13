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

    public function testExample()
    {
        $user1 = User::find(1);
        $user2 = User::find(2);

        //User 1 adds games to their list. 

        //User 2 adds games to their list.

        //Admin runs allocation. Test that User 2 gets theirs as priority. Test that out of stock games aren't allocated. 

        //User 1 returns a game, and User 2 returns one of their games. Test stock affected correctly. 

        //Admin runs allocation. Test that User 2 gets one game, User 1 gets nothing. 


    }
}
