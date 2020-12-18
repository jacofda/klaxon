<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Illuminate\Http\Request;
use Jacofda\Klaxon\Models\{Category, Company, Primitive, Product, Invoice, Item, Stat};

class StatController extends Controller
{
//stats/aziende
    public function companies()
    {
        $year = date('Y')-3;
        $query = Company::has('invoices')
                        ->with('invoices')
                        ->whereHas('invoices', function($query) use($year) {
                            $query->whereYear('data', '>=', $year);
                        })
                         ->orderBy('rag_soc', 'ASC');
        $companiesId = (clone $query)->pluck('rag_soc', 'id')->toArray();

        if(request()->get('ids'))
        {
            $arr = explode('-', request('ids'));
            $companies = Company::whereIn('id', $arr)->paginate(10);
            $companiesIdSelected = $arr;
            $annualStats = Stat::annualStatInvoicesQuery(Company::whereIn('id', $arr));
        }
        else
        {
            $companies = $query->paginate(25);
            $companiesIdSelected = [];
            $annualStats = Stat::annualStatInvoices();
        }

        return view('jacofda::core.accounting.stats.companies', compact('companies', 'annualStats','companiesId', 'companiesIdSelected'));
    }

//stats/categorie
    public function categories()
    {
        $data = []; $graphData = []; $labels = ''; $totali = ''; $fatturato = '';
        foreach(Stat::groupProductsByCategory() as $cat => $products)
        {
            if(request()->get('year'))
            {
                $invoiceIds = Invoice::anno(request('year'))->pluck('id')->toArray();
                $query = Item::whereIn('invoice_id', $invoiceIds)->whereIn('product_id', $products);
                $tot = $query->count();
                $fatt = $query->sum(\DB::raw('iva + importo'));
            }
            else
            {
                $query = Item::whereIn('product_id', $products);
                $tot = $query->count();
                $fatt = $query->sum(\DB::raw('iva + importo'));
            }

            $totali .= '"'.$tot.'",';
            $fatturato .= '"'.$fatt.'",';
            $labels .= '"'.Category::find($cat)->nome.'",';
            $data[$cat]['totali'] = $tot;
            $data[$cat]['fatturato'] = Primitive::NF($fatt);
        }


        $graphData['labels'] = substr($labels, 0, -1);
        $graphData['fatturato'] = substr($fatturato, 0, -1);
        $graphData['totali'] = substr($totali, 0, -1);

        return view('jacofda::core.accounting.stats.categories', compact('graphData', 'data'));
    }


//stats/categorie/{id}
    public function category($id)
    {


        $category = Category::find($id);

        $data = []; $graphData = []; $labels = ''; $totali = ''; $fatturato = '';
        foreach($category->products as $product)
        {
            if(request()->get('year'))
            {
                $invoiceIds = Invoice::anno(request('year'))->pluck('id')->toArray();
                $query = Item::whereIn('invoice_id', $invoiceIds)->where('product_id', $product->id);
                $tot = $query->count();
                $fatt = $query->sum(\DB::raw('iva + importo'));
            }
            else
            {
                $query = Item::where('product_id', $product->id);
                $tot = $query->count();
                $fatt = $query->sum(\DB::raw('iva + importo'));
            }

            $totali .= '"'.$tot.'",';
            $fatturato .= '"'.$fatt.'",';
            $labels .= '"'.$product->nome.'",';
            $data[$product->id]['totali'] = $tot;
            $data[$product->id]['fatturato'] = Primitive::NF($fatt);
        }


        $graphData['labels'] = substr($labels, 0, -1);
        $graphData['fatturato'] = substr($fatturato, 0, -1);
        $graphData['totali'] = substr($totali, 0, -1);

        return view('jacofda::core.accounting.stats.category', compact('category', 'graphData', 'data'));
    }


//stats/balance
    public function balance()
    {

        

        //return Stat::TotaleMese(date('Y'));
        $graphData = Stat::monthlyAnnualGraph();

        return view('jacofda::core.accounting.stats.balance', compact('graphData'));
    }

}
