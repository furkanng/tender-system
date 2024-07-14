<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Service\SovtajYeri\SovtajyeriService;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Service\Otopert\OtopertService;
use App\Service\Autogong\AutogongService;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransferBidMail;
class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter  = $request->input('filter');

        $query = Bid::where('transfer_status','0')->orderBy("created_at","DESC");
        if ($filter) {
            $query->where(function($query) use ($filter) {
                $query->whereHas('tender', function($q) use ($filter) {
                    $q->where('tender_no', 'like', '%' . $filter . '%')
                        ->orWhere('name', 'like', '%' . $filter . '%')
                        ->orWhere('brand', 'like', '%' . $filter . '%')
                        ->orWhere('model', 'like', '%' . $filter . '%')
                        ->orWhere('city', 'like', '%' . $filter . '%')
                        ->orWhere('district', 'like', '%' . $filter . '%');
                })
                    ->orWhereHas('company', function($q) use ($filter) {
                        $q->where('name', 'like', '%' . $filter . '%');
                    })
                    ->orWhereHas('user', function($q) use ($filter) {
                        $q->where('name', 'like', '%' . $filter . '%');
                    });
            });
        }
        $bids = $query->paginate(20);

        return view('panel.pages.bid', compact('bids'));

    }
    public function transferBids(Request $request) {
        $filter  = $request->input('filter');

        $query = Bid::where('transfer_status','1')->orderBy("created_at","DESC");

        if ($filter) {
            $query->where(function($query) use ($filter) {
                $query->whereHas('tender', function($q) use ($filter) {
                    $q->where('tender_no', 'like', '%' . $filter . '%')
                        ->orWhere('name', 'like', '%' . $filter . '%')
                        ->orWhere('brand', 'like', '%' . $filter . '%')
                        ->orWhere('model', 'like', '%' . $filter . '%')
                        ->orWhere('city', 'like', '%' . $filter . '%')
                        ->orWhere('district', 'like', '%' . $filter . '%');
                })
                    ->orWhereHas('company', function($q) use ($filter) {
                        $q->where('name', 'like', '%' . $filter . '%');
                    })
                    ->orWhereHas('user', function($q) use ($filter) {
                        $q->where('name', 'like', '%' . $filter . '%');
                    });
            });
        }
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
        $sovtajyeriService = new SovtajyeriService();
        $user = auth()->guard("user")->user();
        $successMessages =[];

        foreach ($bidIds as $bidId) {
            $bid = Bid::findOrFail($bidId);

            $highestBid = Bid::where('tender_id', $bid->tender_id)->orderBy('bid_price', 'desc')->first();

            //dd($highestBid);
            if ($bid->bid_price < $highestBid->bid_price) {
                $errorMessages[] = 'Sistemde tanımlı daha yüksek teklif bulunduğu için ' . $bid->tender->tender_no . ' nolu ihale aktarılamadı';

            }
            else{
                if($bid->company_id == 2){
                    $response= $otoperService->postTenderOtopert($bid);

                    $result =str_contains($response['response'], 'sonuc basarili');
                    if($result == false){
                        $errorMessages[] = $bid->tender->tender_no.' numaralı teklif aktarılırken bir sorun oluştu!';
                        continue;
                    }

                }
                else if($bid->company_id == 1){
                    $response = $autogongService->postTenderAutogong($bid);
                    $responseJson = json_decode($response['response']);

                        if($responseJson->success != "true"){
                            $errorMessages[] = $bid->tender->tender_no.' numaralı teklif aktarılırken bir sorun oluştu!';
                            continue;
                        }

                }
                else if($bid->company_id == 3){
                    $response = $sovtajyeriService->postTenderSovtajYeri($bid);
                    $responseDecode = json_decode($response['response']);

                    if($responseDecode->HATA == 'true'){
                        $errorMessages[] = $bid->tender->tender_no.' numaralı teklif aktarılırken bir sorun oluştu! '.$responseDecode->ACIKLAMA;
                        continue;

                    }
                }

                $bid->fill(array_merge($request->all(),
                    ["transfer_status" =>  1 ]))->save();

                Mail::to($user->email)->send(new TransferBidMail($user->name, $user->email,$bid->tender->name,$bid->tender->tender_no,json_decode($bid->tender->images,true)[0],$bid->bid_price));


                $successMessages[] = $bid->tender->tender_no." numaralı ihale başarıyla aktarılmıştır.";




            }

        }

        $redirect = redirect()->route('panel.bid.index');

        if (!empty($errorMessages)) {
            $errorHtml = implode('<br>', $errorMessages);
            $redirect->with('error', $errorHtml);
        }

        if (!empty($successMessages)) {
            $successHtml = implode('<br>', $successMessages);
            $redirect->with('message', $successHtml);
        }

        return $redirect;

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

            $otoperService = new OtopertService();
            $autogongService = new AutogongService();
            $sovtajyeriService = new SovtajyeriService();
            $user = auth()->guard("user")->user();


            $bid = Bid::findOrFail($id);

            $highestBid = Bid::where('tender_id', $bid->tender_id)->orderBy('bid_price', 'desc')->first();

        if($request->has("transfer_status")){

            if ($bid->bid_price < $highestBid->bid_price) {

                return redirect()->route('panel.bid.index')->with('error', 'Sistemde tanımlı daha yüksek teklif bulunduğu için teklif aktarılamadı!');

            }
            else{

                if($bid->company_id == 2){


                    $response = $otoperService->postTenderOtopert($bid);
                    $result =str_contains($response['response'], 'sonuc basarili');
                    if($result == false){
                        return redirect()->route('panel.bid.index')->with('error', $bid->tender->tender_no.' numaralı teklif aktarılırken bir sorun oluştu!');
                    }
                }
                else if($bid->company_id == 1){
                    $response = $autogongService->postTenderAutogong($bid);
                    $responseJson = json_decode($response['response']);

                    if($responseJson->success != "true") {
                        return redirect()->route('panel.bid.index')->with('error', $bid->tender->tender_no . ' numaralı teklif aktarılırken bir sorun oluştu!');
                    }
                }
                else if($bid->company_id == 3){
                    $response =$sovtajyeriService->postTenderSovtajYeri($bid);
                    $responseDecode = json_decode($response['response']);

                    if($responseDecode->HATA == 'true'){
                        return redirect()->route('panel.bid.index')->with('error', $bid->tender->tender_no.' numaralı teklif aktarılırken bir sorun oluştu!');

                    }
                }


                $bid->fill(array_merge($request->all(),
                    ["transfer_status" => $request->has("transfer_status") ? 1 : 0]))->save();

                Mail::to($user->email)->send(new TransferBidMail($user->name, $user->email,$bid->tender->name,$bid->tender->tender_no,json_decode($bid->tender->images,true)[0],$bid->bid_price));


                return redirect()->route('panel.bid.index')->with('message', $bid->tender->tender_no.' numaralı ihale başarıyla aktarılmıştır');


            }

        }
        else{
            $bid->fill(array_merge($request->all()))->save();

            return redirect()->route('panel.bid.index')->with('message', 'Teklif Güncellendi');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {




            $bid = Bid::findOrFail($id);
            if ($bid->delete()) {
                return redirect()->route('panel.bid.index')->with('message', 'Teklif Başarıyla Silindi');
            } else {
                return redirect()->route('panel.bid.index')->with('message', 'Silme İşlemi Başarısız');
            }



    }
}
