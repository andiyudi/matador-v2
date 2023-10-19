<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tender;
use App\Models\Partner;
use App\Models\Business;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return view('review.index');
    }

    public function vendor(Request $request)
    {
        $startDate = $request->input('startDateVendor');
        $endDate = $request->input('endDateVendor');

        $startDate = Carbon::createFromFormat('Y', $startDate)->startOfYear();
        $endDate = Carbon::createFromFormat('Y', $endDate)->endOfYear();

        // Mengambil path file logo
        $logoPath = public_path('assets/logo/cmnplogo.png');

        // Membaca file logo dan mengonversi menjadi base64
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        // data pembuat dan atasan
        $creatorNameVendor = request()->query('creatorNameVendor');
        $creatorPositionVendor = request()->query('creatorPositionVendor');
        $supervisorNameVendor = request()->query('supervisorNameVendor');
        $supervisorPositionVendor = request()->query('supervisorPositionVendor');

        // Format bulan dan tahun untuk startDate dan endDate
        $formattedStartDate = Carbon::parse($startDate)->format('Y');
        $formattedEndDate = Carbon::parse($endDate)->format('Y');

        // Ambil semua tender dengan is_selected = 1
        $tenders = Tender::whereHas('businessPartners', function ($query) {
            $query->where('is_selected', '1');
        })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

            $vendorData = $tenders->reduce(function ($carry, $tender) {
                foreach ($tender->businessPartners as $businessPartner) {
                    if ($businessPartner->pivot->is_selected == '1') {
                        $vendorName = $businessPartner->partner->name;
                        $vendorId = $businessPartner->partner->id;

                        if (!isset($carry[$vendorName])) {
                            // Inisialisasi data jika nama perusahaan belum ada
                            $carry[$vendorName] = [
                                'vendorId' => $vendorId,
                                'vendorName' => $vendorName,
                                'core_business' => '', // Inisialisasi core business sebagai string kosong
                                'grade' => ($businessPartner->partner->grade == '0') ? 'Kecil' : (($businessPartner->partner->grade == '1') ? 'Menengah' : 'Besar'),
                                'jumlah_penilaian' => 0,
                                'jumlahValueCost0' => 0,
                                'jumlahValueCost1' => 0,
                                'jumlahValueCost2' => 0,
                                'jumlahContractOrder0' => 0,
                                'jumlahContractOrder1' => 0,
                                'jumlahContractOrder2' => 0,
                                'jumlahWorkImplementation0' => 0,
                                'jumlahWorkImplementation1' => 0,
                                'jumlahWorkImplementation2' => 0,
                                'jumlahPreHandover0' => 0,
                                'jumlahPreHandover1' => 0,
                                'jumlahPreHandover2' => 0,
                                'jumlahFinalHandover0' => 0,
                                'jumlahFinalHandover1' => 0,
                                'jumlahFinalHandover2' => 0,
                                'jumlahInvoicePayment0' => 0,
                                'jumlahInvoicePayment1' => 0,
                                'jumlahInvoicePayment2' => 0,
                            ];
                        }

                        // Update data sesuai tender
                        $carry[$vendorName]['jumlah_penilaian'] += 1;
                        $carry[$vendorName]['jumlahValueCost0'] += $tender->businessPartners()->wherePivot('value_cost', '0')->count();
                        $carry[$vendorName]['jumlahValueCost1'] += $tender->businessPartners()->wherePivot('value_cost', '1')->count();
                        $carry[$vendorName]['jumlahValueCost2'] += $tender->businessPartners()->wherePivot('value_cost', '2')->count();
                        $carry[$vendorName]['jumlahContractOrder0'] += $tender->businessPartners()->wherePivot('contract_order', '0')->count();
                        $carry[$vendorName]['jumlahContractOrder1'] += $tender->businessPartners()->wherePivot('contract_order', '1')->count();
                        $carry[$vendorName]['jumlahContractOrder2'] += $tender->businessPartners()->wherePivot('contract_order', '2')->count();
                        $carry[$vendorName]['jumlahWorkImplementation0'] += $tender->businessPartners()->wherePivot('work_implementation', '0')->count();
                        $carry[$vendorName]['jumlahWorkImplementation1'] += $tender->businessPartners()->wherePivot('work_implementation', '1')->count();
                        $carry[$vendorName]['jumlahWorkImplementation2'] += $tender->businessPartners()->wherePivot('work_implementation', '2')->count();
                        $carry[$vendorName]['jumlahPreHandover0'] += $tender->businessPartners()->wherePivot('pre_handover', '0')->count();
                        $carry[$vendorName]['jumlahPreHandover1'] += $tender->businessPartners()->wherePivot('pre_handover', '1')->count();
                        $carry[$vendorName]['jumlahPreHandover2'] += $tender->businessPartners()->wherePivot('pre_handover', '2')->count();
                        $carry[$vendorName]['jumlahFinalHandover0'] += $tender->businessPartners()->wherePivot('final_handover', '0')->count();
                        $carry[$vendorName]['jumlahFinalHandover1'] += $tender->businessPartners()->wherePivot('final_handover', '1')->count();
                        $carry[$vendorName]['jumlahFinalHandover2'] += $tender->businessPartners()->wherePivot('final_handover', '2')->count();
                        $carry[$vendorName]['jumlahInvoicePayment0'] += $tender->businessPartners()->wherePivot('invoice_payment', '0')->count();
                        $carry[$vendorName]['jumlahInvoicePayment1'] += $tender->businessPartners()->wherePivot('invoice_payment', '1')->count();
                        $carry[$vendorName]['jumlahInvoicePayment2'] += $tender->businessPartners()->wherePivot('invoice_payment', '2')->count();

                        // Inisialisasi koleksi core business untuk vendor ini
                        $vendorCoreBusinesses = collect();

                        // Cari core business berdasarkan vendorId
                        $vendor = Partner::find($vendorId);

                        if ($vendor) {
                            // Dapatkan semua bisnis yang terkait dengan vendor.
                            $data = $vendor->businesses;

                            // Dapatkan semua classification dari bisnis yang tidak memiliki parent_id.
                            $classifications = $data->filter(function ($business) {
                                return $business->parent_id != null;
                            });

                            $parentIds = $classifications->pluck('parent_id')->toArray();

                            // Ambil bisnis yang memiliki parent_id yang sesuai dengan parentIds
                            $core_businesses = Business::whereIn('id', $parentIds)->pluck('name');

                            $number = 1;
                            // Tambahkan core business ini ke koleksi core business untuk vendor ini
                            $core_businesses_with_numbers = $core_businesses->map(function ($core_business) use (&$number) {
                                return $number++ . '.' . $core_business;
                            });

                            $vendorCoreBusinesses = $core_businesses_with_numbers;

                        }

                        // Ubah koleksi core business menjadi string dengan pemisah <br>
                        $carry[$vendorName]['core_business'] = $vendorCoreBusinesses->implode('<br>');
                    }
                }
                return $carry;
            }, []);

            $vendorData = array_values($vendorData);

            // Define a function to calculate the sum of a specific field
            function calculateSum($data, $field) {
                return array_sum(array_column($data, $field));
            }

            // Calculate sums for multiple fields
            $totalData = [
                'totalPenilaian' => calculateSum($vendorData, 'jumlah_penilaian'),
                'totalValueCost0' => calculateSum($vendorData, 'jumlahValueCost0'),
                'totalValueCost1' => calculateSum($vendorData, 'jumlahValueCost1'),
                'totalValueCost2' => calculateSum($vendorData, 'jumlahValueCost2'),
                'totalContractOrder0' => calculateSum($vendorData, 'jumlahContractOrder0'),
                'totalContractOrder1' => calculateSum($vendorData, 'jumlahContractOrder1'),
                'totalContractOrder2' => calculateSum($vendorData, 'jumlahContractOrder2'),
                'totalWorkImplementation0' => calculateSum($vendorData, 'jumlahWorkImplementation0'),
                'totalWorkImplementation1' => calculateSum($vendorData, 'jumlahWorkImplementation1'),
                'totalWorkImplementation2' => calculateSum($vendorData, 'jumlahWorkImplementation2'),
                'totalPreHandover0' => calculateSum($vendorData, 'jumlahPreHandover0'),
                'totalPreHandover1' => calculateSum($vendorData, 'jumlahPreHandover1'),
                'totalPreHandover2' => calculateSum($vendorData, 'jumlahPreHandover2'),
                'totalFinalHandover0' => calculateSum($vendorData, 'jumlahFinalHandover0'),
                'totalFinalHandover1' => calculateSum($vendorData, 'jumlahFinalHandover1'),
                'totalFinalHandover2' => calculateSum($vendorData, 'jumlahFinalHandover2'),
                'totalInvoicePayment0' => calculateSum($vendorData, 'jumlahInvoicePayment0'),
                'totalInvoicePayment1' => calculateSum($vendorData, 'jumlahInvoicePayment1'),
                'totalInvoicePayment2' => calculateSum($vendorData, 'jumlahInvoicePayment2'),
            ];

    return view('review.vendor-result', compact('logoBase64', 'creatorNameVendor', 'creatorPositionVendor', 'supervisorNameVendor', 'supervisorPositionVendor', 'formattedStartDate', 'formattedEndDate', 'vendorData', 'totalData'));
    }
}
