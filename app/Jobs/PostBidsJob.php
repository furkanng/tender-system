<?php

namespace App\Jobs;

use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class PostBidsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    const POST_TENDER_OTOPERT = "https://www.otopert.com.tr/teklif_islemi";
    const POST_TENDER_AUTOGONG = "http://www.autogong.com/ihale/teklif_kaydet";
    const POST_TENDER_SOVTAJYERI= "https://ihale.sovtajyeri.com/class/db_kayit.do";
    /**
     * Create a new job instance.
     */
    protected $bids;
    protected $client;
    protected $failedBids = [];
    public function __construct($bids)
    {
        $this->bids = $bids;
        //$this->client = new Client();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


        foreach ($this->bids as $bidId) {
            $bid = Bid::findOrFail($bidId);



            $highestBid = Bid::where('tender_id', $bid->tender_id)->orderBy('bid_price', 'desc')->first();

            if ($bid->bid_price < $highestBid->bid_price) {
                $this->failedBids[] = $bid;
                continue;
            } else {

                if ($bid->company_id == 2) {
                    $otopertPostFields = [
                        'id' => $bid->tender->car_bid_id,
                        'tutar' => $bid->bid_price
                    ];

                    echo "otopert girdi";
                    /*
                    $response = $this->client->request("POST", self::POST_TENDER_OTOPERT, [
                        "timeout" => 60,
                        "cookies" => $this->jar,
                        "form_params" => $otopertPostFields
                    ])->getBody()->getContents();*/

                } else if ($bid->company_id == 1) {
                    $autogongPostFields = [

                        'ihaleRefNo' => $bid->tender->tender_no,

                        'teklifTutari' => $bid->bid_price

                    ];
                    echo "autogong girdi";

                    /*
               $response = $this->client->request("POST", self::POST_TENDER_AUTOGONG, [
                   "timeout" => 60,
                   "cookies" => $this->jar,
                   "form_params" => $autogongPostFields
               ])->getBody()->getContents();*/
                }
                else if ($bid->company_id == 3) {
                    $sovtajyeriPostFields = [

                        'islem' => 'ihale_cevapla',

                        'id' => $bid->tender->tender_no,
                        'sovtaj' =>$bid->bid_price

                    ];
                    echo "sovtajyeri girdi";

                    /*
               $response = $this->client->request("POST", self::POST_TENDER_SOVTAJYERI, [
                   "timeout" => 60,
                   "cookies" => $this->jar,
                   "form_params" => $autogongPostFields
               ])->getBody()->getContents();*/
                }

                $bid->update(["transfer_status" => 1]);
            }
        }

        Log::info('Failed Bids', ['failedBids' => $this->failedBids]);
    }


}
