<?php

namespace App\Mail;

use App\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GameReceived extends Mailable
{
    use Queueable, SerializesModels;
    public $rental;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@useaquestion.co.uk')
                ->subject('Andach Games: '.$this->rental->game->name.' has been received')
                ->view('email.gamereceived');
    }
}
