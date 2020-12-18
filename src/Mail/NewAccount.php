<?php

namespace Jacofda\Klaxon\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class NewAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $recipient;
    public $pw;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $recipient, $pw)
    {
        $this->recipient = $recipient;
        $this->pw = $pw;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nuovo account '.config('app.name'))
                ->markdown('jacofda::core.emails.users.new-account');
    }
}
