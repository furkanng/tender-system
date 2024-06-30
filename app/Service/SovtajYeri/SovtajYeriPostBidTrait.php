<?php

namespace App\Service\SovtajYeri;

use App\Jobs\Otopert\CarDetailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

trait SovtajYeriPostBidTrait
{
    public function postTenderSovtajYeri($bid){

        try {

                $sovtajyeriPostFields = [

                    'islem' => 'ihale_cevapla',

                    'id' => $bid->tender->tender_no,
                    'sovtaj' =>$bid->bid_price

                ];

                $response = $this->client->request("POST", self::POST_TENDER_SOVTAJYERI, [
                    "timeout" => 60,
                    "cookies" => $this->jar,
                    "form_params" => $sovtajyeriPostFields
                ])->getBody()->getContents();


            $responses = ['Company' => 'Sovtajyeri', 'tender_no'=>$bid->tender->tender_no,'response' => $response];
            return $responses;



        } catch (\Exception $e) {

            return null;
        }
    }


}
