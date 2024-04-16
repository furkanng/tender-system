<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bid;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter  = $request->input('filter');

        $query = Bid::where('transfer_status','0')->orderBy("created_at","DESC");

        $bids = $query->paginate(20);

        return view('panel.pages.bid', compact('bids'));
        
    }
    public function transferBids(Request $request) {
        $filter  = $request->input('filter');

        $query = Bid::where('transfer_status','1')->orderBy("created_at","DESC");

        $transferBids = $query->paginate(20);

        return view('panel.pages.transferBid', compact('transferBids'));
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
        
            $bid = Bid::findOrFail($id);
            $bid->fill(array_merge($request->all(),
                ["transfer_status" => $request->has("transfer_status") ? 1 : 0]))->save();
            return redirect()->route('panel.transferBid')->with('message', 'İşlem Başarılı');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
