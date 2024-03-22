<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Procurement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromView;

class ProcessNegoExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $number = Request::input('number');
        $name = Request::input('name');
        $division = Request::input('division');
        $startDateTtpp = Request::input('startDateTtpp');
        $endDateTtpp = Request::input('endDateTtpp');

        $startDateTtpp = Carbon::createFromFormat('!m-Y', $startDateTtpp)->startOfMonth();
        $endDateTtpp = Carbon::createFromFormat('m-Y', $endDateTtpp)->endOfMonth();

        $startDateCarbon = Carbon::parse($startDateTtpp);
        $endDateCarbon = Carbon::parse($endDateTtpp);

        $formattedStartDate = $startDateCarbon->translatedFormat('F Y');
        $formattedEndDate = $endDateCarbon->translatedFormat('F Y');

        $today = Carbon::now();
        $formattedDate = $today->translatedFormat('d F Y');

        $procurements = Procurement::with('tenders.businessPartners.partner')
        ->where(function ($query) use ($number, $name, $division, $startDateTtpp, $endDateTtpp) {
            if (!empty($number)) {
                $query->where('number', 'LIKE', '%' . $number . '%');
            }

            if (!empty($name)) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            }

            if (!empty($division)) {
                $query->where('division_id', $division);
            }

            if (!empty($startDateTtpp) && !empty($endDateTtpp)) {
                $query->whereBetween('receipt', [$startDateTtpp, $endDateTtpp]);
            }
        })
        ->where('status', '0')
        ->get();

        $reportNegoResults = [];
        $emptyDealNegos = 0;
        $dealNegos = 0;
        $documentsPic = []; //isi dengan data official id yg sudah di group by pada procurement

        foreach ($procurements as $procurement) {
            // Ambil ID resmi dari procurement
            $officialId = $procurement->official->initials;

            // Jika ID resmi belum ada di array, tambahkan dan inisialisasi jumlah procurement menjadi 1
            if (!isset($documentsPic[$officialId])) {
                $documentsPic[$officialId] = 1;
            } else {
                // Jika sudah ada, tambahkan jumlah procurement
                $documentsPic[$officialId]++;
            }
            if ($procurement->deal_nego == null){
                $emptyDealNegos++;
            } else {
                $dealNegos++;
            }
            foreach ($procurement->tenders as $tender) {
                $reportNegoResult = $tender->report_nego_result;
                // Check if $reportNegoResult is not null
                if ($reportNegoResult !== null) {
                    // Add $reportNegoResult to the array using procurement_id as key
                    $reportNegoResults[$procurement->id][] = $reportNegoResult;
                    // Store the latest report_nego_result in the $procurement object
                    $procurement->latest_report_nego_result = $reportNegoResult;
                }
            }

            if ($procurement->status == "2") {
                $procurement->is_selected = 'Canceled';
            } elseif ($procurement->status == "0") {
                $procurement->is_selected = '';
            } else {
                $isSelected = false;
                foreach ($procurement->tenders as $tender) {
                    $selectedVendor = $tender->businessPartners->first(function ($businessPartner) {
                        return $businessPartner->pivot->is_selected === '1';
                    });

                    if ($selectedVendor) {
                        $procurement->is_selected = $selectedVendor->partner->name;
                        $isSelected = true;
                        break;
                    }
                }
                if (!$isSelected) {
                    $procurement->is_selected = 'Unknown';
                }
            }
        }

        return view('recapitulation.process.result', compact('procurements', 'formattedStartDate', 'formattedEndDate', 'formattedDate','emptyDealNegos', 'dealNegos', 'documentsPic'));
    }
}
