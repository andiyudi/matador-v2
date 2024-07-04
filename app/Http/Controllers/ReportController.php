<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Partner;
use App\Models\Business;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function vendor(Request $request)
    {
        $status = $request->input('statusVendor');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $startDate = Carbon::createFromFormat('!m-Y', $startDate)->startOfMonth();
        $endDate = Carbon::createFromFormat('m-Y', $endDate)->endOfMonth();

        $vendorsQuery  = Partner::with(['businesses' => function ($query) {
            $query->where('is_blacklist', "0");
        }]);
        // $vendors = Partner::with('businesses')
            // ->where('status', $status)
            // ->whereBetween('updated_at', [$startDate, $endDate])
            // ->get();
        if ($status == "0") {
            $vendorsQuery->whereBetween('join_date', [$startDate, $endDate]);
        } else {
            $vendorsQuery->where('status', $status)
                            ->whereBetween('updated_at', [$startDate, $endDate]);
        }

        $vendors = $vendorsQuery->get();
        //sembunyikan vendor yg tidak memiliki business partner is_blacklist = 0 kurang dari 1
        // $vendors = $vendors->filter(function ($vendor) {
        //     return $vendor->businesses->isNotEmpty();
        // });
        $vendors->transform(function ($vendor) {
            $vendor->join_date = Carbon::parse($vendor->join_date)->format('d-m-Y');
            return $vendor;
        });
        $vendors->transform(function ($vendor) {
            $coreBusinesses = [];
            $classifications = [];

            foreach ($vendor->businesses as $business) {
                // Jika business memiliki parent, maka ini adalah Classification
                $classifications[] = $business->name;
                // Cek apakah business parent dari classification adalah Core Business
                $parentBusiness = Business::find($business->parent_id);
                if ($parentBusiness && $parentBusiness->parent_id === null) {
                    $coreBusinesses[$parentBusiness->id] = $parentBusiness->name;
                }
            }

            // Mengurutkan array dan menambahkan nomor urut
            sort($coreBusinesses);
            sort($classifications);

            $vendor->core_businesses = implode('<br>', array_map(function ($business, $index) {
                return ($index + 1) . '.' . $business;
            }, $coreBusinesses, array_keys($coreBusinesses)));

            $vendor->classifications = implode('<br>', array_map(function ($business, $index) {
                return ($index + 1) . '.' . $business;
            }, $classifications, array_keys($classifications)));

            return $vendor;
        });

        // Mengambil path file logo
        $logoPath = public_path('assets/logo/cmnplogo.png');

        // Membaca file logo dan mengonversi menjadi base64
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        // data pembuat dan atasan
        $creatorName = request()->query('creatorName');
        $creatorPosition = request()->query('creatorPosition');
        $supervisorName = request()->query('supervisorName');
        $supervisorPosition = request()->query('supervisorPosition');

        // Mapping nilai status
        $statusMapping = [
            "0" => 'Baru',
            "1" => 'Aktif',
            "2" => 'Tidak Aktif',
        ];
        // Mendapatkan nilai status yang lebih deskriptif
        $status = $statusMapping[$status];

        // Format bulan dan tahun untuk startDate dan endDate
        $formattedStartDate = Carbon::parse($startDate)->format('F Y');
        $formattedEndDate = Carbon::parse($endDate)->format('F Y');

        return view('report.vendor-result', compact('vendors', 'logoBase64', 'creatorName', 'creatorPosition', 'supervisorName', 'supervisorPosition', 'status', 'formattedStartDate', 'formattedEndDate'));
    }

    public function blacklist(Request $request)
    {
        $startDateBlacklist = $request->input('startDateBlacklist');
        $endDateBlacklist = $request->input('endDateBlacklist');

        $startDateBlacklist = Carbon::createFromFormat('!m-Y', $startDateBlacklist)->startOfMonth();
        $endDateBlacklist = Carbon::createFromFormat('m-Y', $endDateBlacklist)->endOfMonth();

        $vendors = Partner::with(['businesses' => function ($query) {
            $query->where('is_blacklist', "1");
        }])
        // $vendors = Partner::with('businesses')
            ->whereBetween('updated_at', [$startDateBlacklist, $endDateBlacklist])
            ->get();

        //sembunyikan vendor yg tidak memiliki business partner is_blacklist = 1 kurang dari 1
        $vendors = $vendors->filter(function ($vendor) {
            return $vendor->businesses->isNotEmpty();
        });
        $vendors->transform(function ($vendor) {
            $vendor->join_date = Carbon::parse($vendor->join_date)->format('d-m-Y');
            return $vendor;
        });
        $vendors->transform(function ($vendor) {
            $coreBusinesses = [];
            $classifications = [];

            foreach ($vendor->businesses as $business) {
                // Jika business memiliki parent, maka ini adalah Classification
                $classifications[] = $business->name;
                // Cek apakah business parent dari classification adalah Core Business
                $parentBusiness = Business::find($business->parent_id);
                if ($parentBusiness && $parentBusiness->parent_id === null) {
                    $coreBusinesses[$parentBusiness->id] = $parentBusiness->name;
                }
            }

            // Mengurutkan array dan menambahkan nomor urut
            sort($coreBusinesses);
            sort($classifications);

            $vendor->core_businesses = implode('<br>', array_map(function ($business, $index) {
                return ($index + 1) . '.' . $business;
            }, $coreBusinesses, array_keys($coreBusinesses)));

            $vendor->classifications = implode('<br>', array_map(function ($business, $index) {
                return ($index + 1) . '.' . $business;
            }, $classifications, array_keys($classifications)));

            return $vendor;
        });

        // Mengambil path file logo
        $logoPath = public_path('assets/logo/cmnplogo.png');

        // Membaca file logo dan mengonversi menjadi base64
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        // data pembuat dan atasan
        $creatorName = request()->query('creatorNameBlacklist');
        $creatorPosition = request()->query('creatorPositionBlacklist');
        $supervisorName = request()->query('supervisorNameBlacklist');
        $supervisorPosition = request()->query('supervisorPositionBlacklist');

        // Format bulan dan tahun untuk startDateBlacklist dan endDateBlacklist
        $formattedStartDateBlacklist = Carbon::parse($startDateBlacklist)->format('F Y');
        $formattedEndDateBlacklist = Carbon::parse($endDateBlacklist)->format('F Y');

        return view('report.blacklist-result', compact('vendors', 'logoBase64', 'creatorName', 'creatorPosition', 'supervisorName', 'supervisorPosition', 'formattedStartDateBlacklist', 'formattedEndDateBlacklist'));
    }
}
