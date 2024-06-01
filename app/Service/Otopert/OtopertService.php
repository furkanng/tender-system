<?php

namespace App\Service\Otopert;

use App\Models\Company;
use App\Models\Tender;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Archive;

class OtopertService
{
    use GetTenderTrait, GetArchiveTrait;

    const LOGIN_URL = "https://www.otopert.com.tr/anakontrol/girisyap";
    const TENDERS_URL_LITE = "https://www.otopert.com.tr/yayindaki-ihaleler-lite";
    const CARS_DETAILS = "https://www.otopert.com.tr/arac-detay/";
    const ARCHIVES = "https://www.otopert.com.tr/arsivim/?q=0";

    protected $username;
    protected $password;
    protected $client;
    protected $jar;


    public function __construct()
    {

        $user = Company::findOrFail(2);
        $this->username = $user->email;
        $this->password = $user->password;


        $this->jar = new CookieJar();
        $this->client = new Client();
        $this->login();
    }

    protected function login()
    {

        $fields = [
            "kullanici_adi" => $this->username,
            "md5_sifre" => $this->password
        ];

        $response = $this->loginPost($fields);

        return $response;
    }

    private function loginPost($fields)
    {
        return $this->client->request("POST", self::LOGIN_URL, [
            "form_params" => $fields,
            "timeout" => 50,
            "cookies" => $this->jar
        ])->getBody()->getContents();
    }
}
