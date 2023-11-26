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
    public function index()
    {
        $tenders = Tender::query()->orderBy("created_at", "DESC")->paginate(20);
        return view('panel.pages.ihale', compact("tenders"));
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
            "tender_no" => "required",
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
        $model = Tender::findOrFail($id);
        $model->fill($request->all())->save();
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
