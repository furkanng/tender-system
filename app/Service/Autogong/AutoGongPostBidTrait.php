<?php

namespace App\Service\Autogong;

use App\Jobs\Otopert\CarDetailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

trait AutoGongPostBidTrait
{
    public function postTenderAutogong($bids){

        try {
            if (!is_array($bids)) {
                $bids = [$bids];
            }

            foreach($bids as $bid){

                $postFields = [

                    'ihaleRefNo' => $bid->tender->tender_no,

                    'teklifTutari' => $bid->bid_price

                ];

               // dd($postFields);
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
