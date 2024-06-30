<?php

namespace App\Service\Otopert;

use App\Jobs\Otopert\CarDetailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

trait OtopertPostBidTrait
{
    public function postTenderOtopert($bid){

        try {


                $postFields = [
                    'id' => $bid->tender->car_bid_id,
                    'tutar' => $bid->bid_price
                ];


                $response = $this->client->request("POST", self::POST_TENDER, [
                    "timeout" => 60,
                    "cookies" => $this->jar,
                    "form_params" => $postFields
                ])->getBody()->getContents();

            $responses = ['Company' => 'Otopert', 'tender_no'=>$bid->tender->tender_no,'response' => $response];
            return $responses;



        } catch (\Exception $e) {

            return null;
        }
    }



}
