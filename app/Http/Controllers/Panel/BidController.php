<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Service\Otopert\OtopertService;
use App\Service\Autogong\AutogongService;
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

    public  function transferCheckedBids(Request $request)
    {
        $bidIds = $request->input('bid_ids',[]);
        $otoperService = new OtopertService();
        $autogongService = new AutogongService();

        foreach ($bidIds as $bidId) {
            $bid = Bid::findOrFail($bidId);

            $highestBid = Bid::where('tender_id', $bid->tender_id)->orderBy('bid_price', 'desc')->first();

            //dd($highestBid);
            if ($bid->bid_price < $highestBid->bid_price) {
                $errorMessages[] = 'Sistemde tanımlı daha yüksek teklif bulunduğu için ' . $bid->tender->tender_no . ' nolu ihale aktarılamadı';

            }
            else{
                if($bid->company_id == 2){
                    $otoperService->postTenderOtopert($bid);
                }
                else if($bid->company_id == 1){
                    $autogongService->postTenderAutogong($bid);
                }

                $bid->fill(array_merge($request->all(),
                    ["transfer_status" => $request->has("transferCheckBids") ? 1 : 0]))->save();


            }

        }
        if (!empty($errorMessages)) {
            return redirect()->route('panel.bid.index')->with('error', implode(', ', $errorMessages));
        }
        return redirect()->route('panel.bid.index')->with('message', 'İşlem Başarılı');


    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $otoperService = new OtopertService();
            $autogongService = new AutogongService();



            $bid = Bid::findOrFail($id);

            $highestBid = Bid::where('tender_id', $bid->tender_id)->orderBy('bid_price', 'desc')->first();

            if ($bid->bid_price < $highestBid->bid_price) {


                return redirect()->route('panel.bid.index')->with('error', 'Sistemde tanımlı daha yüksek teklif bulunduğu için teklif aktarılamadı!');

            }
            else{


                $bid->fill(array_merge($request->all(),
                    ["transfer_status" => $request->has("transfer_status") ? 1 : 0]))->save();
                if($request->has("transfer_status")){

                    if($bid->company_id == 2){
                        $otoperService->postTenderOtopert($bid);
                    }
                    else if($bid->company_id == 1){
                        $autogongService->postTenderAutogong($bid);
                    }

                    return redirect()->route('panel.transferBid')->with('message', 'İşlem Başarılı');

                }
                else{
                    return redirect()->route('panel.bid.index')->with('message', 'Teklif Güncellendi');

                }
            }






    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bid = Bid::findOrFail($id);
        if($bid->delete()){
            return redirect()->route('panel.bid.index')->with('message', 'Teklif Başarıyla Silindi');

        }
        else{
            return redirect()->route('panel.bid.index')->with('message', 'Silme İşlemi Başarısız');

        }



    }
}
