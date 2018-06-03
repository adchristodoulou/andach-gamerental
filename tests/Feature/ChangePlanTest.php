<?php

namespace Tests\Feature;

use App\Subscription;
use App\SubscriptionCharge;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChangePlanTest extends TestCase
{
	//Tests a user signing up for a plan, cancelling it, and then uncancelling it. 
	public function testExample_cancel()
	{
        $user = User::find(4);
        $this->be($user);

        $response = $this->followingRedirects()->post('/plan-store', ['plan_id' => 1]);
		$response->assertSee('Thanks, you have successfully subscribed to your plan');

        $response = $this->get('user/subscription');
        $response->assertSee('TEST PLAN 1PERMONTH');
        $response->assertDontSee('Your subscription will end on');

        $response = $this->followingRedirects()->post('/user/subscription/cancel', []);
        $response->assertSee('Are you sure you want to cancel your subscription');

        $response = $this->followingRedirects()->post('/user/subscription/cancel', ['confirm' => 1]);
        $response->assertSee('You have cancelled your subscription');

        $response = $this->get('user/subscription');
        $response->assertSee('TEST PLAN 1PERMONTH');
        $response->assertSee('Your subscription will end on '.date('Y-m-d', strtotime('+1 month')));

        $response = $this->followingRedirects()->post('/user/subscription/resume', []);
        $response->assertSee('Your subscription has been set to resume');

        $response = $this->get('user/subscription');
        $response->assertSee('TEST PLAN 1PERMONTH');
        $response->assertDontSee('Your subscription will end on');
	}

	//Tests a user signing up for a plan and then downgrading. 
    public function testExample_downgrade()
    {
    	$user = User::find(4);
        $this->be($user);

        $response = $this->followingRedirects()->post('/plan-store', ['plan_id' => 2]);
        $response->assertSee('Thanks, you have successfully subscribed to your plan');

        $response = $this->get('user/subscription');
        $response->assertSee('TEST PLAN 1UNLIMITED');
        $response->assertDontSee('Your subscription will end on');

        $sub = Subscription::find(3);
        $this->assertEquals($sub->user_id, 4);
        $this->assertEquals($sub->plan_id, 2);
        $this->assertEquals($sub->starts_at, date('Y-m-d'));
        $this->assertEquals($sub->next_billing_date, date('Y-m-d', strtotime('+1 month')));
        $this->assertEquals($sub->ends_at, null);

        $response = $this->followingRedirects()->post('/plan-store', ['plan_id' => 1]);
        $response->assertSee('Thanks, you have successfully subscribed to your plan');

        $sub = Subscription::find(3);
        $this->assertEquals($sub->user_id, 4);
        $this->assertEquals($sub->plan_id, 2);
        $this->assertEquals($sub->starts_at, date('Y-m-d'));
        $this->assertEquals($sub->next_billing_date, null);
        $this->assertEquals($sub->ends_at, date('Y-m-d', strtotime('+1 month')));

        $sub = Subscription::find(4);
        $this->assertEquals($sub->user_id, 4);
        $this->assertEquals($sub->plan_id, 1);
        $this->assertEquals($sub->starts_at, date('Y-m-d', strtotime('+1 month +1 day')));
        $this->assertEquals($sub->next_billing_date, date('Y-m-d', strtotime('+1 month +1 day')));
        $this->assertEquals($sub->ends_at, null);

        $response = $this->get('/user/subscription');
        $response->assertSee('You are changing plans');

        $response = $this->followingRedirects()->post('/user/subscription/resume');
        $response->assertSee('Your subscription has been set to resume');

        $response = $this->get('/user/subscription');
        $response->assertDontSee('You are changing plans');
    }

    //Tests a user signing up for a plan and then upgrading. 
    public function testExample_upgrade()
    {
        $user = User::find(4);
        $this->be($user);

        $response = $this->followingRedirects()->post('/plan-store', ['plan_id' => 1]);
        $response->assertSee('Thanks, you have successfully subscribed to your plan');

        $response = $this->get('user/subscription');
        $response->assertSee('TEST PLAN 1PERMONTH');
        $response->assertDontSee('Your subscription will end on');

        $charge = SubscriptionCharge::find(1);
        $this->assertEquals($charge->starts_at, date('Y-m-d'));
        $this->assertEquals($charge->ends_at, date('Y-m-d', strtotime('+1 month')));
        $this->assertEquals($charge->charge, 1);
        $this->assertEquals($charge->date_charge_taken, date('Y-m-d'));

        $response = $this->followingRedirects()->post('/plan-store', ['plan_id' => 2]);
        $response->assertSee('Thanks, you have successfully subscribed to your plan');

        $charge = SubscriptionCharge::find(2);
        $this->assertEquals($charge->starts_at, date('Y-m-d'));
        $this->assertEquals($charge->ends_at, date('Y-m-d', strtotime('+1 month')));
        //The exact number of days in the month are going to affect how the actual charge works. Just assert it's strictly between 1 and 1.05. 
        $this->assertGreaterThan(1, $charge->charge);
        $this->assertLessThan(1.05, $charge->charge);
        $this->assertEquals($charge->date_charge_taken, date('Y-m-d'));
    }
}
