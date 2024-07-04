<?php

namespace App\Service\Autogong;

use App\Models\Company;
use App\Service\Autogong\AutoGongPostBidTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class AutogongService
{
    use GetArchiveTrait, GetCarsTrait, GetTenderTrait,AutoGongPostBidTrait;

    const LOGIN_URL = "https://www.autogong.com/uye/uyeGiris";
    const ARSIV_URL = "https://www.autogong.com/ihale/arsivim/";
    const ALL_CARS_URL = "https://www.autogong.com/ihale/";
    const ALL_CARS_DETAIL_URL = "https://www.autogong.com/ihale/ihale_detayi/";

    const POST_TENDER = "https://www.autogong.com/ihale/teklif_kaydet";
    const TENDER_FIRST_PAGE = 1;
    const TENDER_LAST_PAGE = 4;
    const ARCHIVE_FIRST_PAGE = 1;
    const ARCHIVE_LAST_PAGE = 40;

    protected $username;
    protected $password;
    protected $jar;
    protected $client;

    public function __construct()
    {
        $kullanici = Company::findOrFail(1);
        $this->username = $kullanici->email;
        $this->password = $kullanici->password;

        $this->jar = new CookieJar();
        $this->client = new Client();
        $this->login();
    }

    protected function login()
    {
        $fields = [
            "email" => $this->username,
            "password" => $this->password,
        ];

        $response = $this->loginPost($fields);
        $result = json_decode($response, true);
        if ($result["result"] !== "success") {
            echo "firmaya login olunamadı";
            exit();
        }

        return $result;
    }

    private function loginPost($fields)
    {
        return $this->client->request("POST", self::LOGIN_URL, [
            "form_params" => $fields,
            'timeout' => 20,
            'cookies' => $this->jar,
        ])->getBody()->getContents();
    }

}
