<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function tenderVendorSelected()
    {
        return view ('selected.index');
    }

    public function monitoringProcess()
    {
        return view ('monitoring.index');
    }
}
