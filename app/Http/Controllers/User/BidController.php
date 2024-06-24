<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Tender;
use Illuminate\Http\Request;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->guard("user")->user();
        $bids = Bid::where('user_id',$user->id)->get();


        return view('user.pages.myBids',compact('bids'));

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
        $user = auth()->guard("user")->user();

        $bidPrice = $request->input('bid');
        $tender_id = $request->query('tender_id');
        $tender = Tender::findOrFail($tender_id);

        if ($bidPrice % 100 != 0) {
            return redirect()->route('user.tender.index')->with('error', 'Teklif Error');

        }

        $bid = new Bid();
        $bid->fill(
            [
                'user_id'=>$user->id,
                'company_id'=>$tender->company_id,
                'tender_id'=>$tender_id,
                'bid_price'=>$bidPrice,
                'tender_closed_date'=>$tender->closed_date

            ]

        )->save();
        return redirect()->route('user.tender.index')->with('message', 'Kayıt Başarılı');


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
