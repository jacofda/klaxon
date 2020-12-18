<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jacofda\Klaxon\Models\{Setting, Template};

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::latest()->get();
        return view('jacofda::core.templates.index', compact('templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $template = new Template;
            $template->nome = $request->nome;
            $template->contenuto_html = $request->contenuto_html;
            $template->contenuto = $request->contenuto_html;
        $template->save();
        return $template->id;
    }

    public function destroy(Template $template)
    {
        $template->delete();
        return 'done';
    }


//templates/{$template}
    public function show(Template $template)
    {
        if($template->nome == 'Default')
        {
            $setting = Setting::base();
            return view('jacofda::core.templates.default.content', compact('template', 'setting'));
        }
        return view('jacofda::core.templates.show', compact('template'));
    }

//templates/html/{template}
    public function html(Template $template)
    {
        return view('jacofda::core.templates.html', compact('template'));
    }


    public function update(Request $request, Template $template)
    {
        $template->contenuto_html = $request->contenuto_html;
        $template->contenuto = $request->contenuto_html;
        $template->save();
        return 'done';
    }


//
// public function iframe()
// {
//     $template = Template::find(5);
//     return view('models.core.templates.iframe', compact('template'));
// }




}
