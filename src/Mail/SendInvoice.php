<?php

namespace Jacofda\Klaxon\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Jacofda\Klaxon\Models\Company;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, Company $company)
    {
        $this->file = storage_path('app/public/fe/pdf/inviate/'.$name);
        $this->name = $name;
        $this->email = $company->invoice_email;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email)
                    ->subject('Fattura di cortesia')
                    ->markdown('jacofda::core.emails.invoices.send')
                    ->attach($this->file, [
                        'as' => $this->name,
                        'mime' => 'application/pdf',
                    ]);
    }
}
