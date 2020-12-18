<?php

namespace Jacofda\Klaxon\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jacofda\Klaxon\Models\Contact;

class TestNewsletter extends Mailable
{
    use SerializesModels;

    public $content;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content)
    {
        $this->subject = 'TEST '. $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('jacofda::emails.contacts.newsletters.test-newsletter');
    }
}
