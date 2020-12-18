<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Jacofda\Klaxon\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::all();
        return view('jacofda::core.settings.index')->with('settings', $settings);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return view('jacofda::core.settings.edit')->with('setting', $setting);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $default_img_logo = '';$footer_img = ''; $logo_img = '';

        $values = $request->except('_token', '_method');

        if($setting->model == 'SMTP')
        {
            $setting->update(['fields' => $values['smtp']]);
            return redirect('settings')->with('message', 'Setting ' . $setting->model . ' aggiornati');
        }

        if($setting->model == 'Personale')
        {   
            $setting->update(['fields' => $values['personale']]);
            return redirect('settings')->with('message', 'Setting ' . $setting->model . ' aggiornati');
        }

        if($setting->model == 'Newsletter')
        {
            if($request->hasFile('default_img_logo'))
            {
                if ( $request->default_img_logo->isValid() )
                {
                    if($request->default_img_logo->getClientOriginalName() != $setting->default_img_logo)
                    {
                        $default_img_logo = $request->default_img_logo->getClientOriginalName();
                        $request->default_img_logo->storeAs('public/settings', $default_img_logo );
                        $values['default_img_logo'] = $default_img_logo;
                    }
                }
            }
            else
            {
                $values += ['default_img_logo' => $setting->fields['default_img_logo']];
            }
        }


        if($setting->model == 'Base')
        {
            if($request->hasFile('logo_img'))
            {
                if ( $request->logo_img->isValid() )
                {
                    if($request->logo_img->getClientOriginalName() != $setting->logo_img)
                    {
                        $logo_img = $request->logo_img->getClientOriginalName();
                        $request->logo_img->storeAs('public/settings', $logo_img );
                        $values['logo_img'] = $logo_img;
                    }
                }
            }
            else
            {
                $values += ['logo_img' => $setting->fields['logo_img']];
            }


            if($request->hasFile('footer_img'))
            {
                if ( $request->footer_img->isValid() )
                {
                    if($request->footer_img->getClientOriginalName() != $setting->footer_img)
                    {
                        $footer_img = $request->footer_img->getClientOriginalName();
                        $request->footer_img->storeAs('public/settings', $footer_img );
                        $values['footer_img'] = $footer_img;
                    }
                }
            }
            else
            {
                $values += ['footer_img' => $setting->fields['footer_img']];
            }


            if($request->hasFile('logo_fattura_img'))
            {
                if ( $request->logo_fattura_img->isValid() )
                {
                    if($request->logo_fattura_img->getClientOriginalName() != $setting->logo_fattura_img)
                    {
                        $logo_fattura_img = $request->logo_fattura_img->getClientOriginalName();
                        $request->logo_fattura_img->storeAs('public/settings', $logo_fattura_img );
                        $values['logo_fattura_img'] = $logo_fattura_img;
                    }
                }
            }
            else
            {
                $values += ['logo_fattura_img' => $setting->fields['logo_fattura_img']];
            }

        }


        if($default_img_logo != '')
        {
            $values += ['default_img_logo' => $default_img_logo];
        }

        $setting->update(['fields' => $values]);

        return redirect('settings')->with('message', 'Setting ' . $setting->model . ' aggiornati');
    }


}
