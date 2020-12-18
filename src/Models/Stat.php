<?php

namespace Jacofda\Klaxon\Models;

use Illuminate\Support\Facades\Cache;
use \Carbon\Carbon;
use \DB;

class Stat
{

    public static function ImposteQuery($query)
    {
        $sum = $query->consegnate()->entrate()->sum('iva');
        $sum -= $query->consegnate()->notediaccredito()->sum('iva');
        return $sum;
    }

    public static function ImponibileQuery($query)
    {
        $sum = $query->consegnate()->entrate()->sum('imponibile');
        $sum -= $query->consegnate()->notediaccredito()->sum('imponibile');
        return $sum;
    }

    public static function TotaleQuery($query = null)
    {
        if(!is_null($query))
        {
            $imposte = self::ImposteQuery(clone $query);
            $imponibile = self::ImponibileQuery(clone $query);
            return (object) [
                'imposte' => Primitive::NF($imposte),
                'imponibile' => Primitive::NF($imponibile),
                'totale' => Primitive::NF($imposte + $imponibile),
            ];
        }
        return (object) [
            'imposte' => self::Imposte(),
            'imponibile' => self::Imponibile(),
        ];
    }


    public static function Imposte($anno = null)
    {
        if(is_null($anno))
        {
            $imposte = Cache::remember('imposte', 120, function () {
                $sum = Invoice::anno(date('Y'))->consegnate()->entrate()->sum('iva');
                $sum -= Invoice::anno(date('Y'))->consegnate()->notediaccredito()->sum('iva');
                return Primitive::NF( $sum );
            });
        }
        else
        {
            $sum = Invoice::anno($anno)->consegnate()->entrate()->sum('iva');
            $sum -= Invoice::anno($anno)->consegnate()->notediaccredito()->sum('iva');
            $imposte = Primitive::NF( $sum );
        }

        return $imposte;
    }

    public static function ImposteBilancio($anno)
    {
        $sum = Invoice::anno($anno)->consegnate()->entrate()->sum('iva');
        $sum -= Invoice::anno($anno)->consegnate()->notediaccredito()->sum('iva');
        $ivaCosti = Cost::anno($anno)->sum('totale') - Cost::anno($anno)->sum('imponibile');
        return Primitive::NF( $sum - $ivaCosti);
    }

    public static function Imponibile($anno = null)
    {
        if(is_null($anno))
        {
            $imponibile = Cache::remember('imponibile', 120, function () {
                $sum = Invoice::anno(date('Y'))->consegnate()->entrate()->sum('imponibile');
                $sum -= Invoice::anno(date('Y'))->consegnate()->notediaccredito()->sum('imponibile');
                return Primitive::NF(( $sum ));
            });
        }
        else
        {
            $sum = Invoice::anno($anno)->consegnate()->entrate()->sum('imponibile');
            $sum -= Invoice::anno($anno)->consegnate()->notediaccredito()->sum('imponibile');
            $imponibile = Primitive::NF(( $sum ));
        }
        return $imponibile;
    }

    public static function Totale($anno = null)
    {
        if(is_null($anno))
        {
            $imponibile = Cache::remember('imponibile', 120, function () {
                $sum = Invoice::anno(date('Y'))->consegnate()->entrate()->sum(DB::raw('iva + imponibile'));
                $sum -= Invoice::anno(date('Y'))->consegnate()->notediaccredito()->sum(DB::raw('iva + imponibile'));
                return Primitive::NF( $sum );
            });
        }
        else
        {
            if($anno > 2018)
            {
                $sum = Invoice::anno($anno)->consegnate()->entrate()->sum(DB::raw('iva + imponibile'));
                $sum -= Invoice::anno($anno)->consegnate()->notediaccredito()->sum(DB::raw('iva + imponibile'));
            }
            else
            {
                $sum = Invoice::anno($anno)->entrate()->sum(DB::raw('iva + imponibile'));
                $sum -= Invoice::anno($anno)->notediaccredito()->sum(DB::raw('iva + imponibile'));
            }

            $imponibile = Primitive::NF( $sum );
        }
        return $imponibile;
    }



    public static function TotaleMese($year = null)
    {
        if(!is_null($year))
        {
            $years = range($year, ($year-3));
            $arr = [];
            foreach($years as $year)
            {
                for($x=1;$x<=12;$x++)
                {
                    $arr[$year][$x] = self::totMonth($year, str_pad($x, 2, '0', STR_PAD_LEFT));
                }
            }
            return $arr;

        }
        else
        {
            $totale_mese = Cache::remember('totale_mese', 120, function () {
                $arr = [];
                $years = [(date('Y') -1), date('Y')];
                foreach($years as $year)
                {
                    for($x=1;$x<=12;$x++)
                    {
                        $arr[$year][$x] = self::totMonth($year, str_pad($x, 2, '0', STR_PAD_LEFT));
                    }
                }
                return $arr;
            });
        }

        return $totale_mese;
    }

    public static function invoicePageGraph()
    {
        $invoice_page_graph = Cache::remember('invoice_page_graph', 120, function () {
            $arr = [];$labels = '';$data = '';
            for($x=12;$x>=0;$x--)
            {
                $month = Carbon::today()->subMonths($x)->format('m');
                $year = Carbon::today()->subMonths($x)->format('Y');

                $add  = Invoice::mese(['year' => $year, 'month' => $month])->consegnate()->entrate()->sum('imponibile');
                $add -= Invoice::mese(['year' => $year, 'month' => $month])->consegnate()->notediaccredito()->sum('imponibile');

                $labels .= '"'.trans('dates.ms'.$month).'",';
                $data .= $add.',';

            }

            $labels = rtrim($labels,',');
            $data = rtrim($data,',');

            $arr = ['labels' => $labels, 'data' => $data];
            return $arr;
        });
        return $invoice_page_graph;
    }


    public static function monthlyAnnualGraph()
    {
        $data = []; $min = [];
        foreach(range(date('Y')-3, date('Y')-1) as $year)
        {
            $data_set = '';
            for($x=12;$x>=1;$x--)
            {
                $month = sprintf('%02d', $x);
                $add  = self::totMonth($year, $month);
                $min[] = $add;
                $data_set .= $add.',';
            }
            $data[$year] = rtrim($data_set,',');
        }
        $data['min'] = min($min);
        return $data;
    }


    public static function totMonth($year, $month, $to = null)
    {
        if(is_null($to))
        {
            if($year > 2018)
            {
                $entrate = Invoice::mese(['year' => $year, 'month' => $month])->consegnate()->entrate();
                $uscite = Invoice::mese(['year' => $year, 'month' => $month])->consegnate()->notediaccredito();
            }
            else
            {
                $entrate = Invoice::mese(['year' => $year, 'month' => $month])->entrate();
                $uscite = Invoice::mese(['year' => $year, 'month' => $month])->notediaccredito();
            }
            $add  = $entrate->sum(DB::raw('iva + imponibile'));
            $add -= $uscite->sum(DB::raw('iva + imponibile'));
        }
        else
        {
            $add = 0;
            $month = intval($month);
            $end = $month + $to;

            for($month;$month <= $end; $month++)
            {
                if($year > 2018)
                {
                    $entrate = Invoice::mese(['year' => $year, 'month' => sprintf('%02d', $month)])->consegnate()->entrate();
                    $uscite = Invoice::mese(['year' => $year, 'month' => sprintf('%02d', $month)])->consegnate()->notediaccredito();
                }
                else
                {
                    $entrate = Invoice::mese(['year' => $year, 'month' => sprintf('%02d', $month)])->entrate();
                    $uscite = Invoice::mese(['year' => $year, 'month' => sprintf('%02d', $month)])->notediaccredito();
                }
                $add  += $entrate->sum(DB::raw('iva + imponibile'));
                $add -= $uscite->sum(DB::raw('iva + imponibile'));
            }
        }
        return $add;
    }

    public static function totMonthIva($from, $to)
    {
        $addVendite = 0;
        $addAcquisti = 0;
        $month = intval($from);
        $end = $month + $to;

        for($month;$month <= $end; $month++)
        {
            $entrateV = Invoice::mese(['year' => date('Y'), 'month' => sprintf('%02d', $month)])->entrate();
            $usciteV = Invoice::mese(['year' => date('Y'), 'month' => sprintf('%02d', $month)])->notediaccredito();
            $addVendite += $entrateV->sum('iva') - abs($usciteV->sum('iva'));

            $entrateA = Cost::mese(['year' => date('Y'), 'month' => sprintf('%02d', $month)]);
            $addAcquisti += $entrateA->sum(DB::raw('totale - imponibile'));
        }

        return [
            'Vendite' => Primitive::NF($addVendite),
            'Acquisti' => Primitive::NF($addAcquisti),
            'Bilancio' => Primitive::NF($addVendite - $addAcquisti),
        ];
    }


    public static function annualStatInvoices()
    {
        $annual_stats = Cache::remember('annual_stats', 360, function () {
            $arr = [];
            foreach (range(date('Y'), (date('Y')-3), -1) as $year)
            {
                if($year > 2018)
                {
                    $entrate = Invoice::anno($year)->consegnate()->entrate()->sum(DB::raw('iva + imponibile'));
                    $uscite = Invoice::anno($year)->consegnate()->notediaccredito()->sum(DB::raw('iva + imponibile'));
                    $arr[$year] = Primitive::NF( $entrate-abs($uscite) );
                }
                else
                {
                    $entrate = Invoice::anno($year)->entrate()->sum(DB::raw('iva + imponibile'));
                    $uscite = Invoice::anno($year)->notediaccredito()->sum(DB::raw('iva + imponibile'));
                    $arr[$year] = Primitive::NF( $entrate-abs($uscite) );
                }
            }
            return $arr;
        });
        return $annual_stats;
    }

    public static function annualStatInvoicesQuery($query)
    {
        $arr = [];
        foreach (range(date('Y'), (date('Y')-3), -1) as $year)
        {
            $entrate = 0; $uscite = 0;
            if($year > 2018)
            {
                foreach($query->get() as $company)
                {
                    $entrate += $company->invoices()->anno($year)->consegnate()->entrate()->sum(DB::raw('iva + imponibile'));
                    $uscite += abs($company->invoices()->anno($year)->consegnate()->notediaccredito()->sum(DB::raw('iva + imponibile')));
                }
                $arr[$year] = Primitive::NF( $entrate-$uscite );
            }
            else
            {
                foreach($query->get() as $company)
                {
                    $entrate += $company->invoices()->anno($year)->entrate()->sum(DB::raw('iva + imponibile'));
                    $uscite += abs($company->invoices()->anno($year)->notediaccredito()->sum(DB::raw('iva + imponibile')));
                }
                $arr[$year] = Primitive::NF( $entrate-$uscite );
            }
        }
        return $arr;
    }

    public static function Utili($anno = null)
    {

        if(is_null($anno))
        {
            $utili = Cache::remember('imponibile', 120, function () {
                $sum = Invoice::anno(date('Y'))->consegnate()->entrate()->sum(DB::raw('iva + imponibile'));
                $sum -= Invoice::anno(date('Y'))->consegnate()->notediaccredito()->sum(DB::raw('iva + imponibile'));
                $sum -= Cost::anno(date('Y'))->sum('totale');
                return Primitive::NF( $sum );
            });
            return $utili;
        }

        if($anno > 2018)
        {
            $sum = Invoice::anno($anno)->consegnate()->entrate()->sum(DB::raw('iva + imponibile'));
            $sum -= Invoice::anno($anno)->consegnate()->notediaccredito()->sum(DB::raw('iva + imponibile'));
            $sum -= Cost::anno($anno)->sum('totale');
            return Primitive::NF( $sum );
        }
        $sum = Invoice::anno($anno)->entrate()->sum(DB::raw('iva + imponibile'));
        $sum -= Invoice::anno($anno)->notediaccredito()->sum(DB::raw('iva + imponibile'));
        $sum -= Cost::anno($anno)->sum('totale');
        return Primitive::NF( $sum );
    }


//COSTI

    public static function TotaleQueryCosti($query)
    {
        return Primitive::NF($query->sum('totale'));
    }

    public static function ImponibileQueryCosti($query)
    {
        return Primitive::NF($query->sum('imponibile'));
    }

    public static function ImposteQueryCosti($query)
    {
        return Primitive::NF($query->sum(DB::raw('totale - imponibile')));
    }


    public static function CategoriaQueryCosti($query)
    {
        $default = Expense::default();
        $arr = [];
        $categories = Category::categoryOf('Expense')->orderBy('nome', 'asc')->get();

        foreach(Category::categoryOf('Expense')->orderBy('nome', 'asc')->get() as $category)
        {
            $q = clone $query;
            $ids = $category->expenses()->pluck('id')->toArray();
            $arr[$category->nome] = Primitive::NF($q->whereIn('expense_id', $ids)->sum('totale'));
        }
        $q = clone $query;
        $arr[$default->nome] = Primitive::NF($q->where('expense_id', $default->id)->sum('totale'));
        return $arr;
    }


    public static function ImposteCosti($anno = null)
    {
        if(is_null($anno))
        {
            $imposte_costi = Cache::remember('imposte_costi', 120, function () {
                $t = Cost::anno(date('Y'))->sum('totale');
                $t -=  Cost::anno(date('Y'))->sum('imponibile');
                return Primitive::NF( $t );
            });
        }
        else
        {
            $t = Cost::anno($anno)->sum('totale');
            $t -=  Cost::anno($anno)->sum('imponibile');
            return Primitive::NF( $t );
        }

        return $imposte_costi;
    }


    public static function TotaleCosti($anno = null)
    {
        if(is_null($anno))
        {
            $totale_costi = Cache::remember('totale_costi', 120, function () {
                return Primitive::NF( Cost::anno(date('Y'))->sum('totale') );
            });
            return $totale_costi;
        }

        return Primitive::NF( Cost::anno($anno)->sum('totale') );
    }

    public static function CategoriaCosti($anno = null)
    {
        $default = Expense::default();
        $arr = [];
        $categories = Category::categoryOf('Expense')->orderBy('nome', 'asc')->get();

        foreach(Category::categoryOf('Expense')->orderBy('nome', 'asc')->get() as $category)
        {
            $ids = $category->expenses()->pluck('id')->toArray();
            $arr[$category->nome] = Primitive::NF(Cost::anno(date('Y'))->whereIn('expense_id', $ids)->sum('totale'));
        }

        $arr[$default->nome] = Primitive::NF(Cost::anno(date('Y'))->where('expense_id', $default->id)->sum('totale'));
        return $arr;
    }


//IVA
    // public static function IvaCosti($year)
    // {
    //     $costs = Cost::where('anno', $year)->whereRaw('totale-imponibile > 0')
    // }


//PRODUCTS

    /**
     * @return [arr] k: cat_id v: [prod_id]
     */
    public static function groupProductsByCategory()
    {
        $grouped = Cache::remember('grouped', 120, function () {
            $grouped = [];
            foreach(Category::categoryOf("Product")->get() as $category)
            {
                foreach($category->products()->pluck('id')->toArray() as $id)
                {
                    $grouped[intval($category->id)][] = $id;
                }
            }
            return $grouped;
        });

        return $grouped;
    }

}
