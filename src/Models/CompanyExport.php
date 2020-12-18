<?php

namespace Jacofda\Klaxon\Models;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyExport implements FromView
{

    public $companies;

    public function __construct($companies)
    {
        $this->companies = $companies;
    }

    public function view(): View
    {
        return view('jacofda::csv.companies', [
            'companies' => $this->companies
        ]);
    }
}
