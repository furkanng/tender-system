<?php

namespace App\Service\Autogong;

use App\Jobs\Autogong\TenderJob;


trait GetTenderTrait
{
    public function getTender()
    {
        for ($sayfa = 1; $sayfa <= 10; $sayfa++) {
            $response = $this->client->request("POST", self::ALL_CARS_URL, [
                'form_params' => [
                    'ref_no' => 1,
                    'page' => $sayfa
                ],
                'timeout' => 20,
                'cookies' => $this->jar,
            ])->getBody()->getContents();

            TenderJob::dispatchSync($response);
        }
    }
}
