<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscriptionCancel extends Mailable
{
    use Queueable, SerializesModels;
    public $endDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@useaquestion.co.uk')
                ->view('email.subscriptioncancel');
    }
}
