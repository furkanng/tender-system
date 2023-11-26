<?php

namespace App\Service\Autogong;

use App\Jobs\Autogong\DetailJob;
use Symfony\Component\DomCrawler\Crawler;

trait GetCarsTrait
{
    public function allCarsSave()
    {
        $tenderNumbers = $this->getTenderNumber();

        $flatArray = [];

        foreach ($tenderNumbers as $subArray) {
            foreach ($subArray as $item) {
                $flatArray[] = $item[0];
            }
        }

        foreach ($flatArray as $key) {
            DetailJob::dispatch($key);
        }
    }

    public function getTenderNumber()
    {
        $tenderNumbers = [];

        for ($sayfa = 1; $sayfa <= 10; $sayfa++) {
            $response = $this->client->request("POST", self::ALL_CARS_URL, [
                'form_params' => [
                    'ref_no' => 1,
                    'page' => $sayfa
                ],
                'timeout' => 20,
                'cookies' => $this->jar,
            ])->getBody()->getContents();
            $tenderNumbers[] = $this->parseNumberData($response);
        }

        return $tenderNumbers;

    }

    public function parseNumberData($html)
    {
        $crawler = new Crawler($html);

        $numbers = $crawler->filterXpath('//div[@class="right"]')->each(function ($node) {
            $text = $node->text();

            $data = trim(str_replace("&nbsp", "", $text));

            $pattern = '/İHALE NO : (\d+)/u';

            preg_match($pattern, $data, $matches);
            if (count($matches) >= 2) {
                return [
                    $matches[1],
                ];
            } else {
                \Log::error("Hatalı veri: " . $data);
                return null;
            }
        });

        return array_filter($numbers);
    }

    public function getCarsDetail($number)
    {
        $response = $this->client->request("GET", self::ALL_CARS_DETAIL_URL . $number, [
            'timeout' => 20,
            'cookies' => $this->jar,
        ])->getBody()->getContents();

        $carDetail = $this->parseDetailData($response);
        $carDetail[0]["location"] = $this->parseLocationData($response)[0] ?? null;
        $carDetail[0]["damages"] = $this->parseDamageData($response)[0] ?? null;
        $carDetail[0]['tender_no'] = $number;
        $carDetail[0]['images'] = $this->parseImageData($response) ?? null;

        $nameData = $this->parseNameData($response, "name");
        $carDetail[0]["name"] = $nameData[0] ?? null;

        $brandData = $this->parseNameData($response, "brand");
        $carDetail[0]["brand"] = $brandData[0] ?? null;

        $modelData = $this->parseNameData($response, "model");
        $carDetail[0]["model"] = $modelData[0] ?? null;

        $multiDetail[] = $carDetail;

        foreach ($multiDetail as $innerArray) {
            foreach ($innerArray as $item) {
                $outputData = $item;
            }
        }

        return $outputData;
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

        return $crawler->filterXpath('//div[@class="content-width single_table box-shadow"]')
            ->each(function ($node) {
                $text = $node->text();

                $veri = str_replace("&nbsp;", " ", $text);
                return preg_replace('/^HASAR KAYITLARI\s+/', '', $veri);

            });
    }

    public function parseLocationData($html)
    {
        $crawler = new Crawler($html);

        return $crawler->filterXpath('//div[@class="content-width aracin_bulundugu_yer box-shadow"]')
            ->each(function ($node) {
                $text = $node->text();

                $veri = str_replace("&nbsp;", " ", $text);

                $pattern = '/(Servis Adı|Adres|Sabit Tel|İl|İlçe) :/';
                $veriParcalari = preg_split($pattern, $veri, -1, PREG_SPLIT_DELIM_CAPTURE);
                $veriParcalari = array_map('trim', $veriParcalari); // Boşlukları temizle

                return [
                    "ServisAdi" => $veriParcalari[2] ?? null,
                    "Adres" => $veriParcalari[4] ?? null,
                    "SabitTel" => $veriParcalari[6] ?? null,
                    "il" => $veriParcalari[8] ?? null,
                    "ilce" => $veriParcalari[10] ?? null,
                ];

            });
    }

    public function parseDetailData($html)
    {
        $crawler = new Crawler($html);

        return $crawler->filterXpath('//div[@class="content-width arac_detaylari box-shadow"]')
            ->each(function ($node) {
                $text = $node->text();

                $veri = str_replace("&nbsp;", " ", $text);

                preg_match('/İhale Tipi : (.*?) /', $veri, $ihaleTipi);

                preg_match('/TSRSB Bedeli : (.*?) TL/', $veri, $tsrsbBedeli);

                preg_match('/Bulunduğu İl : (.*?) /', $veri, $bulunduguIl);

                preg_match('/Plaka : (.*?) /', $veri, $plaka);

                preg_match('/Model Yılı : (.*?) /', $veri, $modelYili);

                preg_match('/Araç KM : (.*?) /', $veri, $aracKM);

                preg_match('/Yakıt : (.*?) /', $veri, $yakit);

                preg_match('/Vites : (.*?) /', $veri, $vites);

                preg_match('/Araç Türü : (.*?) /', $veri, $aracTuru);

                preg_match('/Silindir : (.*?) /', $veri, $silindir);

                preg_match('/Şase No : (.*?) /', $veri, $shaseNo);

                preg_match('/Hasar Nedeni : (.*?) /', $veri, $hasarNedeni);

                preg_match('/Teklif Katları : (.*?) TL/', $veri, $teklifKatlari);

                return [
                    "ihaleTipi" => $ihaleTipi[1],
                    "tsrsbBedeli" => $tsrsbBedeli[1],
                    "bulunduguIl" => $bulunduguIl[1],
                    "plaka" => $plaka[1],
                    "modelYili" => $modelYili[1],
                    "aracKM" => $aracKM[1],
                    "yakit" => $yakit[1],
                    "vites" => $vites[1],
                    "aracTuru" => $aracTuru[1],
                    "silindir" => $silindir[1],
                    "shaseNo" => $shaseNo[1],
                    "hasarNedeni" => $hasarNedeni[1],
                    "teklifKatlari" => $teklifKatlari[1],
                ];

            });
    }

    public function parseNameData($html, $type)
    {
        $crawler = new Crawler($html);

        return $crawler->filter('.content-width.title')
            ->each(function ($node) use ($type) {
                $text = $node->text();

                $text = str_replace("&nbsp;", " ", $text);
                $veri = str_replace("SATIŞA HAZIR", "", $text);

                $explode = explode(" - ", $veri);

                $brand = $explode[0];

                $modelexplode = preg_replace("/^\d+\s*/", "", $explode[1] ?? null);

                $modelimplode = explode(" ", $modelexplode);
                $model = $modelimplode[0];

                if ($type == "name") {
                    return $veri;
                } elseif ($type == "brand") {
                    return $brand;
                } elseif ($type == "model") {
                    return $model;
                }
            });
    }
}
