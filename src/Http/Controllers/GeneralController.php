<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Calendar, City, Company, Contact, Country, Editor, Event, Invoice, Item, Media, Newsletter, NewsletterList, Notification, Product, Report, Role, Template, User};
use \Carbon\Carbon;
use \Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;

class GeneralController extends Controller
{
    public function updateField(Request $request)
    {
        $model = $this->findModel($request);
        if($model)
        {
            $model->update([$request->field => $request->value]);

            if($request->model === 'Item')
            {
                $this->updateInvoice($model);
            }
            return 'done';
        }

        return 'not found';
    }

    public function findModel($data)
    {
        if ( class_exists('Jacofda\\Klaxon\\Models\\'.$data->model) )
		{
            $class = 'Jacofda\\Klaxon\\Models\\'.$data->model;
			return $class::findOrFail($data->id);
		}
        return null;
    }

    public function updateInvoice($model)
    {
        $invoice = $model->invoice;
        $invoice_iva = 0;
        $invoice_imponibile = 0;
        foreach($invoice->items as $item)
        {
            $qta = $item->qta;
            $importo = $item->importo;
            $sconto = (1-($item->sconto)/100);
            $perc_iva = $item->perc_iva/100;

            $invoice_iva += ($importo*$qta)*$sconto*$perc_iva;//ivato totale riga con sconto
            $invoice_imponibile += $importo*$qta*$sconto;//senza iva

            $item->update([
                'iva' => ($importo*$qta)*$sconto*$perc_iva,
            ]);

        }

        $invoice->update([
            'imponibile' => $invoice_imponibile,
            'iva' => $invoice_iva
        ]);
    }

//api/countries - POST
    public function prefix()
    {
        return Country::getCountryPhone(request('iso'));
    }

//api/city
    public function zip()
    {
        $city = City::where('comune', request('citta'))->first();
        if($city)
        {
            return ['cap' => $city->cap, 'provincia' => $city->provincia];
        }
        return '';
    }


//api/clear-cache - POST
    public function clearCache()
    {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return 'done';
    }

    public function switchLocale()
    {
        if(app()->getLocale() == 'en')
        {
            session()->put('locale', 'it');
        }
        else
        {
            session()->put('locale', 'en');
        }
        return back();
    }

}
