<?php

namespace Jacofda\Klaxon\Http\Controllers;

use Jacofda\Klaxon\Models\Erp\Log;
use Illuminate\Support\Facades\Schema;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::orderBy('created_at', 'DESC')->paginate(50);
        return view('jacofda::core.erp.logs.index', compact('logs'));
    }

    public function truncate()
    {
        Schema::disableForeignKeyConstraints();
        Log::truncate();
        Schema::enableForeignKeyConstraints();
        return 'done';
    }

}
