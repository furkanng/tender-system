<?php

namespace App\Service\Autogong;

use App\Jobs\Autogong\DetailJob;
use Symfony\Component\DomCrawler\Crawler;

trait GetCarsTrait
{
    public function allCarsSave()
    {
        $tenderNumbers = $this->getTenderNumber();

        foreach ($tenderNumbers as $key) {
            DetailJob::dispatchSync($key);
        }
    }

    public function getTenderNumber()
    {
        $tenderNumbers = [];

        for ($sayfa = 1; $sayfa <= 2; $sayfa++) {
            $response = $this->client->request("POST", self::ALL_CARS_URL, [
                'form_params' => [
                    'ref_no' => 1,
                    'page' => $sayfa
                ],
                'timeout' => 20,
                'cookies' => $this->jar,
            ])->getBody()->getContents();

            $pageTenderNumbers = $this->parseNumberData($response);
            $tenderNumbers = array_merge($tenderNumbers, $pageTenderNumbers);
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
                \Log::error("Hatalı veri: " . $id);
                return null;
            }
        });

        $numbers = array_filter($numbers);

        return array_filter($numbers);
    }

    public function getCarsDetail($number)
    {
        $response = $this->client->request("GET", self::ALL_CARS_DETAIL_URL . $number, [
            'timeout' => 20,
            'cookies' => $this->jar,
        ])->getBody()->getContents();

        $carDetail = $this->parseDetailData($response);
        $carDetail["location"] = $this->parseLocationData($response) ?? null;
        $carDetail["damages"] = $this->parseDamageData($response) ?? null;
        $carDetail['tender_no'] = $number;
        $carDetail['images'] = $this->parseImageData($response) ?? null;

        $carDetail["title"] = $this->parseNameData($response, "name");

        return $carDetail;
    }

    public function parseImageData($html)
    {
        $crawler = new Crawler($html);

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

        return json_encode($imageUrls);
    }

    public function parseDamageData($html)
    {
        $crawler = new Crawler($html);

        $data = $crawler->filter('.xad-damage-records .card .card-body .card-table')->each(function ($node) {
            $text = $node->text();
            $text = str_replace("&nbsp;", " ", $text);
            $text = trim($text);

            return $text;
        });

        // Veriyi düzenle ve istenen formatta döndür
        return $data[0];
    }

    public function parseLocationData($html)
    {
        $crawler = new Crawler($html);

        $data = [
            "ServisAdi" => '',
            "Adres" => '',
            "CepTel" => '',
            "il" => '',
            "ilce" => '',
            "contract" => '',
        ];

        $crawler->filter('.xad-damage-records .card .card-body .card-table .card-table-content')->each(function ($node) use (&$data) {
            $title = $node->filter('.card-table-title')->text();
            $info = $node->filter('.card-table-info')->text();

            switch ($title) {
                case 'Servis Adı':
                    // 'Anlaşmasız' veya 'Anlaşmalı' kelimelerini kontrol et ve kaldır
                    if (strpos($info, 'Anlaşmasız') !== false) {
                        $data['contract'] = 'Anlaşmasız';
                        $info = str_replace(' Anlaşmasız', '', $info);
                    } else {
                        $data['contract'] = 'Anlaşmalı';
                        $info = str_replace(' Anlaşmalı', '', $info);
                    }
                    // 'span' etiketini kaldır
                    $info = preg_replace('/<span[^>]*>.*<\/span>/', '', $info);
                    $data['ServisAdi'] = trim($info);
                    break;
                case 'Adres':
                    $data['Adres'] = $info;
                    break;
                case 'Cep Tel':
                    $data['CepTel'] = $info;
                    break;
                case 'İl':
                    $data['il'] = $info;
                    break;
                case 'İlçe':
                    $data['ilce'] = $info;
                    break;
            }
        });

        return $data;
    }

    public function parseDetailData($html)
    {
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
                "ihaleNo" => trim($ihaleNo),
                "ihaleTipi" => trim($ihaleTipi),
                "tsrsbBedeli" => trim($tsrsbBedeli),
                "bulunduguIl" => trim($bulunduguIl),
                "plaka" => trim($plaka),
                "modelYili" => trim($modelYili),
                "aracKM" => trim($aracKM),
                "yakit" => trim($yakit),
                "vites" => trim($vites),
                "aracTuru" => trim($aracTuru),
                "silindir" => trim($silindir),
                "shaseNo" => trim($shaseNo),
                "hasarNedeni" => trim($hasarNedeni)
            ];
        });

        // Detayları filtreleyip düzeltmek için
        if (!empty($detailData)) {
            return $detailData[0]; // Eğer birden fazla varsa, ilkini döndürüyoruz
        } else {
            return []; // Eğer veri yoksa boş dizi döndürüyoruz
        }
    }

    public function parseNameData($html)
    {
        $crawler = new Crawler($html);

        // İlk başta boş bir dizi tanımla
        $data = [];

        // Veriyi filtrele ve parçala
        $crawler->filter('.xad-breadcrumb h4')->each(function ($node) use (&$data) {
            $text = $node->text();
            $text = str_replace("&nbsp;", " ", $text);
            $text = trim($text);

            // Veriyi " - " ile parçalayarak marka, model ve yılı ayır
            $explode = explode(" - ", $text);

            $data = [
                'brand' => $explode[0] ?? '',
                'model' => $explode[1] ?? '',
                'year' => $explode[2] ?? '',
            ];
        });

        return $data;
    }
}
