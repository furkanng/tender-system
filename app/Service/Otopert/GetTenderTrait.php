<?php

namespace App\Service\Otopert;

use App\Jobs\Otopert\CarDetailJob;
use App\Models\Tender;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

trait GetTenderTrait
{

    public function getAllCarsLite()
    {
        $response = $this->client->request("GET", self::TENDERS_URL_LITE, [
            "timeout" => 60,
            "cookies" => $this->jar
        ])->getBody()->getContents();

        CarDetailJob::dispatchSync($response);
    }

    public function getCarDetails($desiredPart)
    {
        $response = $this->client->request("GET", self::CARS_DETAILS . $desiredPart, [
            "timeout" => 60,
            "cookies" => $this->jar
        ])->getBody()->getContents();

        $crawler = new Crawler($response);

        $carName = $crawler->filter('h1.ui-title')->text();
        $targetDiv = $crawler->filter('.b-goods-f__info.bitis_tarihi');
        $carImages = $crawler->filter('div.b-goods-f__slider a');
        $srcArray = $carImages->extract(['data-src']);

        // Diziyi JSON formatına çevirin
        $carImagesEncoded = json_encode($srcArray);

        $fullContent = $targetDiv->text();
        $dateInfo = str_replace(['İhale Bitiş Tarihi:', ' 50:14:46'], '', $fullContent);
        $dateInfo = trim($dateInfo);
        $dateInfo = str_replace(
            ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            $dateInfo
        );

        $carDetails = $this->getCarDetailData($crawler);

        $carDetails[0]['Name'] = $carName;
        $carDetails[0]['TenderNo'] = $desiredPart;
        $carDetails[0]['TenderClosedDate'] = Carbon::parse($dateInfo)->timestamp;
        $carDetails[0]['Images'] = $carImagesEncoded;

        $allDetailsData[] = $carDetails;


        $mergedArray = [];

        foreach ($allDetailsData as $item) {
            // Her array içindeki 0 ve 1 indeksli alt array'leri birleştir
            $mergedArray[] = array_merge($item[0], $item[1]);
        }

        foreach ($mergedArray as $detailArray) {

            $output = $detailArray;
        }

        return $output;
    }

    public function getCarDetailData($crawler)
    {

        $tableData = [];
        // `dl` etiketlerini seçiyoruz
        $crawler->filter('dl.b-goods-f__descr')->each(function (Crawler $dlNode) use (&$tableData) {
            // Her bir `dl` etiketi içindeki `dt` ve `dd` etiketlerini seçiyoruz
            $dtNodes = $dlNode->filter('dt');
            $ddNodes = $dlNode->filter('dd');


            // Başlık ve değerleri sırasıyla alıyoruz
            $titles = $dtNodes->each(function (Crawler $dtNode) {
                return $dtNode->text();
            });

            $values = $ddNodes->each(function (Crawler $ddNode) {
                return $ddNode->text();
            });

            // Başlık ve değerleri birleştirip assoicative bir diziye ekliyoruz
            $tableData[] = array_combine($titles, $values);
        });
        return $tableData;
    }
}
