<?php

namespace App\Http\Controllers;

use App\User;
use Braintree\WebhookNotification;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

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
        Mail::to($user)->send(new BraintreeDebug($notification));
    }

    public function handleSubscriptionChargedUnsuccessfully(WebhookNotification $notification)
    {
        $user = User::find(1);
        Mail::to($user)->send(new BraintreeDebug($notification));
    }
}