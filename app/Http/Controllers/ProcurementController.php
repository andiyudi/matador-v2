<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Official;
use App\Models\Procurement;
use Illuminate\Http\Request;
use App\DataTables\ProcurementDataTable;
use RealRashid\SweetAlert\Facades\Alert;

class ProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProcurementDataTable $dataTable)
    {
        return $dataTable->render('procurement.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::where('status', '1')->get();
        $officials = Official::where('status', '1')->get();
        return view('procurement.create', compact('divisions', 'officials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'receipt' => 'required',
            'name' => 'required',
            'number' => 'required|unique:procurements',
            'division' => 'required',
            'official' => 'required',
        ]);
        // Create a new procurement
        $procurement = new Procurement();
        $procurement->receipt = $request->input('receipt');
        $procurement->name = $request->input('name');
        $procurement->number = $request->input('number');
        $procurement->division_id = $request->input('division');
        $procurement->official_id = $request->input('official');
        $procurement->save();

        Alert::success('Success', 'Procurement data has been saved.');
        return redirect()->route('procurements.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Procurement $procurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($procurementId)
    {
        $id = decrypt($procurementId);
        $procurement = Procurement::findOrFail($id);

         // Cek status procurement
        if ($procurement->status != 0) {
            // Jika status bukan 0, arahkan ke halaman yang sesuai
            Alert::error('Error','Procurement cannot be edited because already success or canceled.');
            return redirect()->back();
        }

        $divisions = Division::where('status', '1')->get();
        $officials = Official::where('status', '1')->get();
        return view('procurement.edit', compact('procurement', 'divisions', 'officials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'receipt' => 'required',
            'name' => 'required',
            'number' => 'required|unique:procurements,number,' . $id,
            'division' => 'required',
            'official' => 'required',
        ]);

        $procurement = Procurement::find($id);

        $procurement->receipt = $request->receipt;
        $procurement->name = $request->name;
        $procurement->number = $request->number;
        $procurement->division_id = $request->division;
        $procurement->official_id = $request->official;
        $procurement->save();

        Alert::success('Success', 'Procurement data has been updated.');
        return redirect()->route('procurements.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Procurement $procurement)
    {
        try {
            if ($procurement->tenders()->count() > 0) {
                throw new \Exception('Procurement data can\'t be deleted, it is associated with tender(s).');
            }

            $procurement->delete();
            Alert::success('Success', 'Procurement data has been deleted.');
            return redirect()->route('procurements.index');
        } catch (\Exception $e) {
            Alert::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete procurement data: ' . $e->getMessage());
        }
    }
}
