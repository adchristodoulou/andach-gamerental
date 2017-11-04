<?php

namespace App\Mail;

use App\Plan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscriptionChange extends Mailable
{
    use Queueable, SerializesModels;
    public $plan;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@useaquestion.co.uk')
                ->view('email.subscriptionchange');
    }
}
