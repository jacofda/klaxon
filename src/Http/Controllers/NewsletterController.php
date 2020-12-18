<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Jacofda\Klaxon\Models\{Newsletter, NewsletterList, Contact, Setting, Template};
use Illuminate\Http\Request;
use Jacofda\Klaxon\Jobs\{SendNewsletter, SendTestNewsletter, SendNewsletterCompleted};
use Carbon\Carbon;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsletters = Newsletter::latest()->get();
        return view('jacofda::core.newsletters.index', compact('newsletters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lists = [1 => 'Tutti i Contatti']+NewsletterList::pluck('nome', 'id')->toArray();
        $templates = Template::pluck('nome', 'id')->toArray();
        $smtps = \Jacofda\Klaxon\Models\Setting::smtpPluck();
        return view('jacofda::core.newsletters.create', compact('lists', 'templates', 'smtps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $default = Template::Default();
        $this->validate(request(),[
            'descrizione' => 'required_if:template_id,==,'.$default->id
        ]);

        if($request->template_id == $default->id)
        {
            $newsletter = new Newsletter;
                $newsletter->nome = $request->nome;
                $newsletter->oggetto = $request->oggetto;
                $newsletter->descrizione = $request->descrizione;
                $newsletter->template_id = $request->template_id;
                $newsletter->smtp_id = $request->smtp_id;
            $newsletter->save();

            Template::makeDefault();
        }
        else
        {
            $newsletter = new Newsletter;
                $newsletter->nome = $request->nome;
                $newsletter->oggetto = $request->oggetto;
                $newsletter->descrizione = $request->descrizione;
                $newsletter->template_id = $request->template_id;
                $newsletter->smtp_id = $request->smtp_id;
            $newsletter->save();
        }
        $newsletter->lists()->attach($request->list_id);

        return redirect('newsletters')->with('message', 'Newsletter Creata');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classes\Contacts\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $newsletter)
    {
        $lists = [1 => 'Tutti i Contatti']+NewsletterList::pluck('nome', 'id')->toArray();
        $templates = Template::pluck('nome', 'id')->toArray();
        $smtps = \Jacofda\Klaxon\Models\Setting::smtpPluck();
        return view('jacofda::core.newsletters.edit', compact('lists', 'templates', 'newsletter', 'smtps'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classes\Contacts\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter $newsletter)
    {
        if($request->template_id == Template::Default()->id)
        {
            $newsletter->nome = $request->nome;
            $newsletter->oggetto = $request->oggetto;
            $newsletter->descrizione = $request->descrizione;
            $newsletter->template_id = $request->template_id;
            $newsletter->smtp_id = $request->smtp_id;
            $newsletter->save();

            Template::makeDefault();
        }
        else
        {
            $newsletter->nome = $request->nome;
            $newsletter->oggetto = $request->oggetto;
            $newsletter->descrizione = $request->descrizione;
            $newsletter->template_id = $request->template_id;
            $newsletter->smtp_id = $request->smtp_id;
            $newsletter->save();
        }

        $newsletter->lists()->sync($request->list_id);

        return redirect(route('newsletters.index'))->with('message', 'Newsletter Aggiornata');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classes\Contacts\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->lists()->detach();
        $newsletter->delete();
        return 'done';
    }

//newsletter/{id}/send-test - GET
    public function test(Newsletter $newsletter)
    {
        return view('jacofda::core.newsletters.send-test', compact('newsletter'));
    }

//newsletter/{id}/send-test - POST
    public function sendTest(Newsletter $newsletter)
    {
        foreach(Setting::defaultTestEmail(request('email')) as $recipient)
        {
            $args = [
                'sender' => Setting::defaultSendFrom(),
                'recipient' => $recipient,
                'subject' => $newsletter->oggetto,
                'content' => is_null($newsletter->template->contenuto) ? $newsletter->template->contenuto_html : $newsletter->template->contenuto,
                'newsletter' => $newsletter
            ];
            dispatch( (new SendTestNewsletter($args) )->delay( Carbon::now()->addSeconds(5) ) );
        }

        return redirect(route('newsletters.index'))->with('message', 'Test email spedita');
    }

//newsletter/{id}/send - GET
    public function send(Newsletter $newsletter)
    {
        $sender = Setting::smtp($newsletter->smtp_id);
        return view('jacofda::core.newsletters.send', compact('newsletter', 'sender'));
    }

//newsletter/{id}/send - POST
    public function sendOfficial(Newsletter $newsletter)
    {
        $sender = Setting::defaultSendFrom();
        $delay = Carbon::now()->addSeconds(5);


        $newsletter->contenuto = $newsletter->template->contenuto;
        $newsletter->save();


        if($newsletter->lists()->where('list_id', 1)->exists())
        {
            Contact::subscribed()->chunk(4, function($contacts) use(&$delay, $newsletter) {
                dispatch( (new SendNewsletter($contacts, $newsletter))->delay($delay->addSeconds(60)) );
            });
        }
        else
        {
            foreach($newsletter->lists as $list)
            {
                $list->contacts()->chunk(4, function($contacts) use(&$delay, $newsletter) {
                    dispatch( (new SendNewsletter($contacts, $newsletter))->delay($delay->addSeconds(60)) );
                });
            }
        }


        dispatch( (new SendNewsletterCompleted('Campagna spedita', $newsletter->id))->delay($delay->addSeconds(15)) );

        return back()->with('message', 'Processo iniziato. Vi notificheremo quando sarà consluso.');
    }



}
