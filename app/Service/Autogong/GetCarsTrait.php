<?php

namespace App\Service\Autogong;

use App\Jobs\Autogong\DetailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

trait GetCarsTrait
{
    public function allCarsGet()
    {
        try {
            $tenderNumbers = $this->getTenderNumber();

            foreach ($tenderNumbers as $key) {
                DetailJob::dispatch($key);
            }
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }

    public function getTenderNumber()
    {
        $tenderNumbers = [];

        try {
            for ($page = self::TENDER_FIRST_PAGE; $page <= self::TENDER_LAST_PAGE; $page++) {
                $response = $this->client->request("POST", self::ALL_CARS_URL, [
                    'form_params' => [
                        'ref_no' => 1,
                        'page' => $page
                    ],
                    'timeout' => 20,
                    'cookies' => $this->jar,
                ])->getBody()->getContents();

                $pageTenderNumbers = $this->parseNumberData($response);
                $tenderNumbers = array_merge($tenderNumbers, $pageTenderNumbers);
            }
        } catch (\Exception $e) {
            $this->handleError($e);
        }

        return $tenderNumbers;
    }

    public function parseNumberData($html)
    {
        $crawler = new Crawler($html);

        $numbers = $crawler->filterXpath('//div[@class="xad-content"]')->each(function ($node) {
            $id = $node->attr('id');
            if (preg_match('/arac_liste_(\d+)/', $id, $matches)) {
                return $matches[1];
            } else {
                $this->handleError(new \Exception("Hatalı veri: " . $id));
                return null;
            }
        });

        $numbers = array_filter($numbers);

        return array_filter($numbers);
    }

    public function getCarsDetail($number)
    {
        try {
            $response = $this->client->request("GET", self::ALL_CARS_DETAIL_URL . $number, [
                'timeout' => 20,
                'cookies' => $this->jar,
            ])->getBody()->getContents();

            return array_filter($this->parseDetailData($response));
        } catch (\Exception $e) {
            $this->handleError($e);
            return [];
        }
    }


    public function parseDetailData($html)
    {
        try {
            $crawler = new Crawler($html);

            // Tek bir araç detayını almak için
            $detailData = $crawler->filterXpath('//div[@class="xad-detail"]')->each(function ($node) {
                // İlgili alanların değerlerini alıyoruz
                $ihaleNo = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="İhale NO"]]')->text();
                $ihaleTipi = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="İhale Tipi"]]')->text();
                $tsrsbBedeli = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="TSRSB Bedeli"]]')->text();
                $bulunduguIl = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Bulunduğu İl"]]')->text();
                $plaka = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Plaka"]]')->text();
                $modelYili = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Model Yılı"]]')->text();
                $aracKM = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Araç KM"]]')->text();
                $yakit = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Yakıt"]]')->text();
                $vites = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Vites"]]')->text();
                $aracTuru = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Araç Türü"]]')->text();
                $silindir = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Silindir"]]')->text();
                $shaseNo = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Şase No"]]')->text();
                $hasarNedeni = $node->filterXpath('.//div[@class="card-table-info"][preceding-sibling::div[text()="Hasar Nedeni"]]')->text();

                return [
                    "tender_no" => trim($ihaleNo),
                    "tender_doc" => trim($ihaleTipi),
                    "tsrsb" => trim($tsrsbBedeli),
                    "city" => trim($bulunduguIl),
                    "plate" => trim($plaka),
                    "year" => trim($modelYili),
                    "km" => trim($aracKM),
                    "fuel_type" => trim($yakit),
                    "gear" => trim($vites),
                    "car_type" => trim($aracTuru),
                    "roll" => trim($silindir),
                    "sase_no" => trim($shaseNo),
                    "damages" => trim($hasarNedeni),
                ];
            });

            $serviceData = [
                "service_name" => '',
                "address" => '',
                "service_phone" => '',
                "city" => '',
                "district" => '',
                "service_type" => '',
            ];

            $crawler->filter('.xad-damage-records .card .card-body .card-table .card-table-content')->each(function ($node) use (&$serviceData) {
                $title = $node->filter('.card-table-title')->text();
                $info = $node->filter('.card-table-info')->text();

                switch ($title) {
                    case 'Servis Adı':
                        if (strpos($info, 'Anlaşmasız') !== false) {
                            $serviceData['service_type'] = 'Anlaşmasız';
                            $info = str_replace(' Anlaşmasız', '', $info);
                        } else {
                            $serviceData['service_type'] = 'Anlaşmalı';
                            $info = str_replace(' Anlaşmalı', '', $info);
                        }
                        $serviceData['service_name'] = trim($info);
                        break;
                    case 'Adres':
                        $serviceData['address'] = $info;
                        break;
                    case 'Cep Tel':
                        $serviceData['service_phone'] = $info;
                        break;
                    case 'İl':
                        $serviceData['city'] = $info;
                        break;
                    case 'İlçe':
                        $serviceData['district'] = $info;
                        break;
                }
            });

            $tenderData = array_merge($detailData[0], $serviceData);

            $damageData = $crawler->filter('.xad-damage-records .card .card-body .card-table')->each(function ($node) {
                $text = $node->text();
                $text = str_replace("&nbsp;", " ", $text);
                $text = trim($text);

                return $text;
            });

            $tenderData["damages"] = $damageData[0];

            $liElements = $crawler->filter('#lightgallery li[data-src]'); // data-src özelliğine sahip li etiketlerini seç

            $imageUrls = [];

            foreach ($liElements as $li) {
                $liCrawler = new Crawler($li); // Her bir li için ayrı bir Crawler oluştur
                $img = $liCrawler->filter('img'); // li içindeki img etiketlerini filtrele

                if ($img->count() > 0) {
                    $imageUrl = $liCrawler->attr('data-src');
                    $imageUrls[] = $imageUrl;
                }
            }

            $tenderData["images"] = json_encode($imageUrls);

            $nameData = [];

            $crawler->filter('.xad-breadcrumb h4')->each(function ($node) use (&$nameData) {
                $text = $node->text();
                $text = str_replace("&nbsp;", " ", $text);
                $text = trim($text);

                // Veriyi " - " ile parçalayarak marka, model ve yılı ayır
                $explode = explode(" - ", $text);

                $nameData = [
                    'brand' => $explode[0] ?? '',
                    'model' => $explode[1] ?? '',
                ];
            });

            $tenderData = array_merge($tenderData, $nameData);

            $pattern = '/"ihale_bitis_tarihi":\s*"([^"]+)"/';
            preg_match($pattern, $html, $matches);

            // Eşleşen değeri alıyoruz
            if (!empty($matches) && isset($matches[1])) {
                $ihaleBitisTarihi = $matches[1];
            } else {
                $ihaleBitisTarihi = '';
            }

            // ihale_bitis_tarihi değerini timestamp'e çeviriyoruz
            if (!empty($ihaleBitisTarihi)) {
                $timestamp = Carbon::parse($ihaleBitisTarihi)->timestamp;
            } else {
                $timestamp = null; // Eğer ihale_bitis_tarihi değeri boşsa null döndürüyoruz
            }

            $tenderData["closed_date"] = $timestamp;

            return $tenderData;

        } catch (\Exception $e) {
            $this->handleError($e);
            return [];
        }
    }

    private function handleError(\Exception $e)
    {
        Log::error('An error occurred', [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    }

}
