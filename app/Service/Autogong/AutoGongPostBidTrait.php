<?php

namespace App\Service\Autogong;

use App\Jobs\Otopert\CarDetailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

trait AutoGongPostBidTrait
{
    public function postTenderAutogong($bid){

        try {

                $postFields = [

                    'ihaleRefNo' => $bid->tender->tender_no,

                    'teklifTutari' => $bid->bid_price

                ];


                $response = $this->client->request("POST", self::POST_TENDER, [
                    "timeout" => 60,
                    "cookies" => $this->jar,
                    "form_params" => $postFields
                ])->getBody()->getContents();



            $responses = ['Company' => 'Autogong','tender_no'=>$bid->tender->tender_no, 'response' => $response];
            return $responses;

        } catch (\Exception $e) {

            return null;
        }
    }


}
