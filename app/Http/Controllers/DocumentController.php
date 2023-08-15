<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\FilesPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($partner_id)
    {
        $partner = Partner::find($partner_id);
        $files = FilesPartner::where('partner_id', $partner_id)->get();
        return view ('partner.document.index', compact('partner', 'files'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($partner_id)
    {
        $partner = Partner::find($partner_id);
        return view ('partner.document.create', compact('partner'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'file' => 'required',
                'id_partner' => 'required',
                'type' => 'required|in:0,1,2',
            ]);

            $partner_id = Partner::findOrFail($request->id_partner);
            if ($request->hasFile('file')){
                $file = $request->file('file');
                $name = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('files_partner', $name, 'public');

                $filePartner = new FilesPartner();

                $filePartner->partner_id  = $partner_id->id;
                $filePartner->name        = $name;
                $filePartner->path        = $path;
                $filePartner->type        = $request->type;
                $filePartner->notes       = $request->notes;

                $filePartner->save();
                Alert::success('Success','File added successfully');
                return redirect()->route('document.index', $partner_id);
            } else {
                Alert::error('Error', 'No file uploaded.');
            }

        } catch (\Throwable $th) {
            Alert::error('Error', 'Failed to add File: ' . $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($file_id)
    {
        $file = FilesPartner::findOrFail($file_id);

        // Delete the file from storage
        Storage::disk('public')->delete($file->path);

        // Delete the file record from the database
        $file->delete();

        Alert::success('Success','File deleted successfully');
        return redirect()->back();
    }
}
