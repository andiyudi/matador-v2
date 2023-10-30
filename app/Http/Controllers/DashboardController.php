<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function getVendorCount(): JsonResponse
    {
        $registeredCount = Partner::where('status', '0')->count();
        $activeCount = Partner::where('status', '1')->count();
        $expiredCount = Partner::where('status', '2')->count();

        $totalVendorCount = Partner::count();

        return response()->json([
            'success' => true,
            'totalVendor' => $totalVendorCount,
            'registered' => $registeredCount,
            'active' => $activeCount,
            'expired' => $expiredCount,
        ]);
    }

    public function getProcurementCount(): JsonResponse
    {
        $processProcurement = Procurement::where('status', '0')->count();
        $successProcurement = Procurement::where('status', '1')->count();
        $canceledProcurement = Procurement::where('status', '2')->count();

        $totalProcurementCount = Procurement::count();

        return response()->json([
            'success' => true,
            'totalProcurement' => $totalProcurementCount,
            'processProcurement' => $processProcurement,
            'successProcurement' => $successProcurement,
            'canceledProcurement' => $canceledProcurement,
        ]);
    }

    public function getDataTableVendor(): JsonResponse
    {
        $latestVendors = Partner::orderBy('created_at', 'desc')->limit(5)->get();

        return response()->json([
            'success' => true,
            'data' => $latestVendors,
        ]);
    }

    public function getDataTableProcurement(): JsonResponse
    {
        $latestProcurement = Procurement::orderBy('created_at', 'desc')->limit(5)->get();

        return response()->json([
            'success' => true,
            'data' => $latestProcurement,
        ]);
    }
}
