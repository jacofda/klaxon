<?php

namespace Jacofda\Klaxon\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Jacofda\Klaxon\Models\{Setting, Newsletter, Report};
use Jacofda\Klaxon\Mail\OfficialNewsletter;

class SendNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 7200;

    protected $contacts;
    protected $newsletter;
    protected $configuration;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contacts, Newsletter $newsletter)
    {
        $this->contacts = $contacts;
        $this->newsletter = $newsletter;
        $this->configuration = Setting::smtp( $newsletter->smtp_id );
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailer = app()->makeWith('custom.mailer', $this->configuration);

        foreach ($this->contacts as $contact)
        {
            if( !Report::where('newsletter_id', $this->newsletter->id)->where('contact_id', $contact->id)->exists() )
            {
                $report = Report::create([
                    'newsletter_id' => $this->newsletter->id,
                    'contact_id' => $contact->id,
                    'identifier' => str_random(16)
                ]);

                try
                {
                    $mailer->to($contact->email)->send( new OfficialNewsletter( $this->newsletter->oggetto, $this->newsletter->addTrackingAndPersonalize($report->identifier, $contact)) );
                }
                catch(\Exception $e)
                {
                    $report->update([
                        'delivered' => 0,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

    }
}
