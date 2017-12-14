<?php

namespace App\Http\Controllers;

use App\Mail\BraintreeDebug;
use App\Subscription;
use App\User;
use Braintree\WebhookNotification;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Mail;

class WebhookController extends CashierController
{
    /**
     * Handle a Braintree webhook.
     *
     * @param  WebhookNotification  $webhook
     * @return Response
     */
    public function handleCheck(WebhookNotification $notification)
    {
        $user = User::find(1);
        Mail::to($user)->send(new BraintreeDebug($notification));
    }

    public function handleDisputeOpened(WebhookNotification $notification)
    {
        $user = User::find(1);
        Mail::to($user)->send(new BraintreeDebug($notification));
    }

    public function handleSubscriptionChargedSuccessfully(WebhookNotification $notification)
    {
        $user = User::find(1);
	Mail::to($user)->send(new BraintreeDebug($notification->subject['subscription']['id']));
	$sub = Subscription::where('braintree_id', $notification->subject['subscription']['id'])->first();
	$sub->user->resetMonthlyRentalCount();
//        Mail::to($user)->send(new BraintreeDebug($notification));
    }

    public function handleSubscriptionChargedUnsuccessfully(WebhookNotification $notification)
    {
        $user = User::find(1);
        Mail::to($user)->send(new BraintreeDebug($notification));
    }

    public function handleSubscriptionWentActive(WebhookNotification $notification)
    {
        $user = User::find(1);
        Mail::to($user)->send(new BraintreeDebug($notification));
    }
}
