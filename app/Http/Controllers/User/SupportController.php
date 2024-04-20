<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supports = Support::query()->where("user_id", auth()->guard("user")->user()->id)->get();
        return view("user.pages.support", compact("supports"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("user.pages.supportCreate");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required",
            "content" => "required",
        ]);

        $model = new Support();
        $model->fill(array_merge($request->all(),
            [
                "user_id" => auth()->guard("user")->user()->id,
                "read" => "customer"
            ]
        ))->save();

        return redirect()->route("user.support.index")->with("Talebiniz iletilmiştir.");
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
        $support = Support::findOrFail($id);
        return view("user.pages.supportEdit", compact("support"));
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
    public function destroy(string $id)
    {
        //
    }
}
