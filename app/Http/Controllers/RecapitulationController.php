<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Division;
use App\Models\Official;
use App\Models\Procurement;
use Illuminate\Http\Request;

class RecapitulationController extends Controller
{
    public function getProcessNego ()
    {
        $divisions = Division::where('status', '1')->get();
        return view ('recapitulation.process.index', compact('divisions'));
    }

    public function getProcessNegoData(Request $request)
    {
        $logoPath = public_path('assets/logo/cmnplogo.png');
        $logoData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        $number = $request->input('number');
        $name = $request->input('name');
        $division = $request->input('division');
        $startDateTtpp = $request->input('startDateTtpp');
        $endDateTtpp = $request->input('endDateTtpp');

        $startDateTtpp = Carbon::createFromFormat('m-Y', $startDateTtpp)->startOfMonth();
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
        ->get();

        foreach ($procurements as $procurement) {
            if ($procurement->status == "2") {
                $procurement->is_selected = 'Canceled';
            } elseif ($procurement->status == "0") {
                $procurement->is_selected = 'Process';
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

        return view('recapitulation.process.data', compact('logoBase64', 'procurements', 'formattedStartDate', 'formattedEndDate', 'formattedDate'));
    }
}
