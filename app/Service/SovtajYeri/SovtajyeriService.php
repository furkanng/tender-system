<?php

namespace App\Service\SovtajYeri;

use App\Models\Company;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class SovtajyeriService
{
    use GetTenderTrait, GetArchiveTrait;

    const URL = "https://ihale.sovtajyeri.com";
    const LOGIN_URL = "https://ihale.sovtajyeri.com/giris_kontrol.do?";
    const ALL_TENDERS = "https://ihale.sovtajyeri.com/ihale/pert_ihaleler.do?route=&sayfa=";

    const ARCHIVE_URL = "https://ihale.sovtajyeri.com/rapor/ihale_arsivim.do?route=rapor/ihale_arsivim";
    const TENDER_FIRST_PAGE = 1;
    const TENDER_LAST_PAGE = 10;

    protected $username;
    protected $password;
    protected $jar;
    protected $client;

    public function __construct()
    {
        $kullanici = Company::findOrFail(3);
        $this->username = $kullanici->email;
        $this->password = $kullanici->password;

        $this->jar = new CookieJar();
        $this->client = new Client();
        $this->login();
    }

    protected function login()
    {
        $fields = [
            "kullanici" => $this->username,
            "sifre" => $this->password,
        ];

        $response = $this->loginPost($fields);
        $result = json_decode($response, true);

        if ($result["HATA"] == true) {
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
