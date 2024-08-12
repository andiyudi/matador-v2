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

        $vendors  = Partner::with(['businesses' => function ($query) {
            $query->where('is_blacklist', "0");
        }])
            ->where('status', $status)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->get();

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

    public function join(Request $request)
    {
        $startDateJoin = $request->input('startDateJoin');
        $endDateJoin = $request->input('endDateJoin');
        $report_type = $request->input('report_type');

        $creatorNameJoin = request()->query('creatorNameJoin');
        $creatorPositionJoin = request()->query('creatorPositionJoin');
        $supervisorNameJoin = request()->query('supervisorNameJoin');
        $supervisorPositionJoin = request()->query('supervisorPositionJoin');

        $startDateJoin = Carbon::createFromFormat('!m-Y', $startDateJoin)->startOfMonth();
        $endDateJoin = Carbon::createFromFormat('m-Y', $endDateJoin)->endOfMonth();

        $vendors  = Partner::with(['businesses' => function ($query) {
            $query->where('is_blacklist', "0");
        }])
        ->whereBetween('join_date', [$startDateJoin, $endDateJoin])
        ->orderBy('join_date', 'asc')
        ->get();

        if ($report_type === 'detail') {
            // logika untuk laporan detail
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
            $formattedStartDateJoin = Carbon::parse($startDateJoin)->format('F');
            $formattedEndDateJoin = Carbon::parse($endDateJoin)->format('F Y');
            return view('report.new-detail-result', compact('vendors', 'formattedStartDateJoin', 'formattedEndDateJoin', 'creatorNameJoin', 'creatorPositionJoin', 'supervisorNameJoin', 'supervisorPositionJoin'));
        } else if ($report_type === 'summary') {
            // Logika untuk laporan ringkasan
            // Buat daftar semua bulan dalam rentang waktu
            $allMonths = [];
            $currentDate = $startDateJoin->copy();

            while ($currentDate->lte($endDateJoin)) {
                $allMonths[$currentDate->format('F Y')] = [
                    'total_vendors' => 0,
                    'core_businesses' => [],
                ];
                $currentDate->addMonth();
            }

            // Group data vendors berdasarkan bulan dan tahun
            $groupedVendors = $vendors->groupBy(function ($vendor) {
                return Carbon::parse($vendor->join_date)->format('F Y');
            });

            // Isi data summary sesuai bulan
            foreach ($groupedVendors as $monthYear => $vendorsInMonth) {
                $allMonths[$monthYear]['total_vendors'] = $vendorsInMonth->count();

                // Inisialisasi core business untuk setiap bulan
                foreach ($vendorsInMonth as $vendor) {
                    $firstCoreBusiness = null;

                    foreach ($vendor->businesses as $business) {
                        // Cek apakah business parent dari classification adalah Core Business
                        $parentBusiness = Business::find($business->parent_id);
                        if ($parentBusiness && $parentBusiness->parent_id === null) {
                            if (!$firstCoreBusiness) {
                                $firstCoreBusiness = $parentBusiness->name;

                                if (!isset($allMonths[$monthYear]['core_businesses'][$firstCoreBusiness])) {
                                    $allMonths[$monthYear]['core_businesses'][$firstCoreBusiness] = [
                                        'count' => 0,
                                        'grades' => ['0' => 0, '1' => 0, '2' => 0] // Initialize grades
                                    ];
                                }

                                // Hanya tambahkan satu core business untuk vendor ini
                                $allMonths[$monthYear]['core_businesses'][$firstCoreBusiness]['count'] += 1;
                            }
                        }
                    }
                }

                // Hitung data grade berdasarkan core business
                foreach ($vendorsInMonth as $vendor) {
                    foreach ($vendor->businesses as $business) {
                        $parentBusiness = Business::find($business->parent_id);
                        if ($parentBusiness && $parentBusiness->parent_id === null) {
                            $coreBusinessName = $parentBusiness->name;

                            if (isset($allMonths[$monthYear]['core_businesses'][$coreBusinessName])) {
                                $grade = $vendor->grade;
                                $allMonths[$monthYear]['core_businesses'][$coreBusinessName]['grades'][$grade] += 1;

                                // Pastikan jumlah total grade tidak lebih dari jumlah vendor core business
                                $totalGrades = array_sum($allMonths[$monthYear]['core_businesses'][$coreBusinessName]['grades']);
                                if ($totalGrades > $allMonths[$monthYear]['core_businesses'][$coreBusinessName]['count']) {
                                    $excess = $totalGrades - $allMonths[$monthYear]['core_businesses'][$coreBusinessName]['count'];
                                    // Adjust grades to ensure total does not exceed the count
                                    foreach (array_keys($allMonths[$monthYear]['core_businesses'][$coreBusinessName]['grades']) as $gradeKey) {
                                        if ($allMonths[$monthYear]['core_businesses'][$coreBusinessName]['grades'][$gradeKey] > $excess) {
                                            $allMonths[$monthYear]['core_businesses'][$coreBusinessName]['grades'][$gradeKey] -= $excess;
                                            break;
                                        } else {
                                            $excess -= $allMonths[$monthYear]['core_businesses'][$coreBusinessName]['grades'][$gradeKey];
                                            $allMonths[$monthYear]['core_businesses'][$coreBusinessName]['grades'][$gradeKey] = 0;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // Remove grades with value 0
                foreach ($allMonths[$monthYear]['core_businesses'] as $coreBusiness => &$data) {
                    $data['grades'] = array_filter($data['grades'], function($gradeCount) {
                        return $gradeCount > 0;
                    });
                }
            }
            // dd($allMonths);
            $formattedStartDateJoin = Carbon::parse($startDateJoin)->locale('id')->translatedFormat('F');
            $formattedEndDateJoin = Carbon::parse($endDateJoin)->locale('id')->translatedFormat('F Y');
            return view('report.new-summary-result', compact('allMonths', 'creatorNameJoin', 'creatorPositionJoin', 'supervisorNameJoin', 'supervisorPositionJoin', 'formattedStartDateJoin', 'formattedEndDateJoin'));
        }
    }
}
