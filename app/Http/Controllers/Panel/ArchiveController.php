<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter');

        $query = $filter
            ? Archive::where('tender_no', 'LIKE', '%' . $filter . '%')
                ->orWhere('company_name', 'LIKE', '%' . $filter . '%')
                ->orWhere('plate', 'LIKE', '%' . $filter . '%')
                ->orWhere('car', 'LIKE', '%' . $filter . '%')
                ->orWhere('city', 'LIKE', '%' . $filter . '%')
                ->orWhere('status', 'LIKE', '%' . $filter . '%')
                ->orderBy("date", "DESC")
            : Archive::orderBy("date", "DESC");

        $archives = $query->paginate(20);

        return view('panel.pages.arsiv', compact('archives'));
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
    public function destroy(string $id)
    {
        //
    }
}
