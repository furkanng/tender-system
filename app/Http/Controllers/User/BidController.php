<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Setting;
use App\Models\Tender;
use Carbon\Carbon;
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

        $model = new Setting();
        $general = $model->get("general_settings");
        $tenderFactor = $general["site_tender_factor"];
        $bidPrice = $request->input('bid');
        $tender_id = $request->query('tender_id');
        $tender = Tender::findOrFail($tender_id);

        $tenderClosedDate = Carbon::createFromTimestamp($tender["closed_date"]);
        $now = Carbon::now();
        if ($bidPrice % $tenderFactor != 0) {
            return redirect()->back()->with('tenderFactorError',$tenderFactor );

        }

        if($tenderClosedDate->lessThan($now)){
            return redirect()->back()->with('tenderClosedTimeError', 'Teklif Error');
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
        return redirect()->back()->with('message', 'Kayıt Başarılı');


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

        if (auth()->user()->role != 2) {
            return redirect()->route('user.bid.index')->with('authorizeError', 'Yetkisiz işlem!Güncelleme yapabilmek için VIP yetkiniz olmalı');
        }

        $bid = Bid::findOrFail($id);

        if($bid->transfer_status == 1){
            return redirect()->route('user.bid.index')->with('transferredError', 'Verdiğiniz teklif aktarıldığı için düzenleme yapılamaz!');

        }

        $bid->fill([
            'bid_price' => $request->bid_price,

        ])->save();


        return redirect()->route('user.bid.index')->with('message', 'İşlem Başarılı');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
