<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Support;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supports = Support::all();
        return view("panel.pages.support", compact("supports"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $support = Support::findOrFail($id);
        return view("panel.pages.supportEdit", compact("support"));
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
        $request->validate([
            "answer" => "required"
        ]);

        $model = new SupportMessage();
        $model->fill(array_merge($request->all(), [
            "admin_id" => auth()->guard("admin")->user()->id,
            "support_id" => $id
        ]))->save();

        $support = Support::findOrFail($id);
        $support->read = "admin";
        $support->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
