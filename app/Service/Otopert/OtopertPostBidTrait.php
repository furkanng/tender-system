<?php

namespace App\Service\Otopert;

use App\Jobs\Otopert\CarDetailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

trait OtopertPostBidTrait
{
    public function postTenderOtopert($bids){

        try {
            if (!is_array($bids)) {
                $bids = [$bids];
            }

            foreach($bids as $bid){

                $postFields = [
                    'id' => $bid->tender->car_bid_id,
                    'tutar' => $bid->bid_price
                ];
                dd($postFields);
                /*
                $response = $this->client->request("POST", self::POST_TENDER, [
                    "timeout" => 60,
                    "cookies" => $this->jar,
                    "form_params" => $postFields
                ])->getBody()->getContents();*/


            }

        } catch (\Exception $e) {

            return null;
        }
    }



}
