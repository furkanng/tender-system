<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter');

        $query = $filter
            ? Tender::where('tender_no', 'LIKE', '%' . $filter . '%')
                ->orWhere('name', 'LIKE', '%' . $filter . '%')
                ->orWhere('brand', 'LIKE', '%' . $filter . '%')
                ->orWhere('model', 'LIKE', '%' . $filter . '%')
                ->orWhere('year', 'LIKE', '%' . $filter . '%')
                ->orWhere('plate', 'LIKE', '%' . $filter . '%')
                ->orWhere('fuel_type', 'LIKE', '%' . $filter . '%')
                ->orWhere('sase_no', 'LIKE', '%' . $filter . '%')
                ->orWhere('servicePhone', 'LIKE', '%' . $filter . '%')
                ->orWhere('city', 'LIKE', '%' . $filter . '%')
                ->orWhere('district', 'LIKE', '%' . $filter . '%')
                ->orderBy("created_at", "DESC")
            : Tender::orderBy("created_at", "DESC");

        $tenders = $query->paginate(20);

        return view('panel.pages.ihale', compact('tenders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.pages.ihaleCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "tender_no" => "required",//todo exist
            "tender_type" => "required",
            "brand" => "required",
            "name" => "required",
        ]);
        (new Tender())->mergeFillable([
            "status", "tender_no"
        ])->fill([
            'status' => $request->has('status') ? 1 : 0,
            'tender_no' => "WS-" . $request->get('tender_no')
        ])->fill($request->except(["status", "tender_no"]))->save();
        return redirect()->route('panel.tender.index')->with('success', 'İşlem Başarılı');
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
        $tenders = Tender::findOrFail($id);
        return view('panel.pages.ihaleEdit', compact("tenders"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "tender_type" => "sometimes|required",
            "brand" => "sometimes|required",
            "name" => "sometimes|required",
        ]);
        $model = Tender::findOrFail($id);
        $model->mergeFillable([
            "status", "tender_no"
        ])->fill([
            'status' => $request->has('status') ? 1 : 0,
        ])->fill($request->except(["status"]))->save();
        return redirect()->route('panel.tender.index')->with('success', 'İşlem Başarılı');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
