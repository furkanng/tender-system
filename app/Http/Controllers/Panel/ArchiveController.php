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
            ? Archive::leftJoin('tenders', 'archives.tender_no', '=', 'tenders.tender_no')
                ->leftJoin('bids', 'tenders.id', '=', 'bids.tender_id')
                ->leftJoin('users', 'bids.user_id', '=', 'users.id')
            ->select('archives.*', 'tenders.images','users.name as bid_user_name')->where('tender_no', 'LIKE', '%' . $filter . '%')
                //->orWhere('company_name', 'LIKE', '%' . $filter . '%')
                ->orWhere('plate', 'LIKE', '%' . $filter . '%')
                ->orWhere('car', 'LIKE', '%' . $filter . '%')
                ->orWhere('city', 'LIKE', '%' . $filter . '%')
                ->orWhere('status', 'LIKE', '%' . $filter . '%')
                ->orderBy("date", "DESC")
            : Archive::leftJoin('tenders', 'archives.tender_no', '=', 'tenders.tender_no')
                ->leftJoin('bids', 'tenders.id', '=', 'bids.tender_id')
                ->leftJoin('users', 'bids.user_id', '=', 'users.id')
            ->select('archives.*', 'tenders.images','users.name as bid_user_name')->orderBy("date", "DESC");


        $archives = $query->paginate(20);


        $archives->appends(['filter' => $filter]);
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
        $archive = Archive::findOrFail($id);
        return view('panel.pages.arsivEdit', compact("archive"));
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
