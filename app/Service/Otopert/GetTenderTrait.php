<?php

namespace App\Service\Otopert;

use App\Jobs\Otopert\CarDetailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

trait GetTenderTrait
{
    public function getAllCarsLite()
    {
        try {
            $response = $this->client->request("GET", self::TENDERS_URL_LITE, [
                "timeout" => 60,
                "cookies" => $this->jar
            ])->getBody()->getContents();

            $this->getCars($response);
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }

    public function getCars($html)
    {
        $crawler = new Crawler($html);

        $response = [];
        $desiredPart = $crawler->filter('.b-goods-f h2')->each(function (Crawler $h2Node) use (&$response) {
            try {
                // H2 içindeki ilk a etiketinin href değerini alıyoruz
                $firstHrefValue = $h2Node->filter('a')->first()->attr('href');
                return str_replace('https://www.otopert.com.tr/arac-detay/', '', $firstHrefValue);
            } catch (\Exception $e) {
                $this->handleError($e);
                return null;
            }
        });

        foreach ($desiredPart as $part) {
            if ($part) {
                try {
                    CarDetailJob::dispatch($part);
                } catch (\Exception $e) {
                    $this->handleError($e);
                }
            }
        }
    }
    
    public function getCarBidId($crawler){
        $numericValues = [];
        try {
            $elements = $crawler->filter('.teklif_alani');

            $elements->each(function ($node) use (&$numericValues) {
                $id = $node->attr('id');
    
                // Regex ile sayısal değeri ayıklayın
                preg_match('/\d+/', $id, $matches);
    
                if (!empty($matches)) {
                    $numericValues[] = $matches[0];
                }
            });
            return $numericValues;
        } catch (\Exception $e) {
            $this->handleError($e);
            return $numericValues;
        }
       

    }

    public function getCarDetails($desiredPart)
    {
        try {
            $response = $this->client->request("GET", self::CARS_DETAILS . $desiredPart, [
                "timeout" => 60,
                "cookies" => $this->jar
            ])->getBody()->getContents();

            $crawler = new Crawler($response);

            $carNameNode = $crawler->filter('h1.ui-title');
            if ($carNameNode->count() === 0) {
                throw new \Exception('Car name node not found');
            }
            $carName = $carNameNode->text();

            $targetDivNode = $crawler->filter('.b-goods-f__info.bitis_tarihi');
            if ($targetDivNode->count() === 0) {
                throw new \Exception('Target div node not found');
            }

            $carImagesNode = $crawler->filter('div.b-goods-f__slider a');
            $srcArray = $carImagesNode->extract(['data-src']);
            $carImagesEncoded = json_encode($srcArray);

            $fullContent = $targetDivNode->text();
            $dateInfo = str_replace(['İhale Bitiş Tarihi:', ' 50:14:46'], '', $fullContent);
            $dateInfo = trim($dateInfo);
            $dateInfo = str_replace(
                ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
                ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                $dateInfo
            );

            $carDetails = $this->getCarDetailData($crawler);
            if (empty($carDetails)) {
                throw new \Exception('Car details not found');
            }
            $carBidId = $this->getCarBidId($crawler);

            $carDetails[0]['Name'] = $carName;
            $carDetails[0]['TenderNo'] = $desiredPart;
            $carDetails[0]['TenderClosedDate'] = Carbon::parse($dateInfo)->timestamp;
            $carDetails[0]['Images'] = $carImagesEncoded;
            $carDetails[0]['CarBidId'] = $carBidId[0];

            
            
            $allDetailsData[] = $carDetails;

            $mergedArray = [];

            foreach ($allDetailsData as $item) {
                $mergedArray[] = array_merge($item[0], $item[1]);
            }

            foreach ($mergedArray as $detailArray) {
                $output = $detailArray;
            }

            return $output;
        } catch (\Exception $e) {
            $this->handleError($e);
            return null;
        }
    }

    public function getCarDetailData($crawler)
    {
        $tableData = [];
        try {
            $crawler->filter('dl.b-goods-f__descr')->each(function (Crawler $dlNode) use (&$tableData) {
                try {
                    $dtNodes = $dlNode->filter('dt');
                    $ddNodes = $dlNode->filter('dd');

                    if ($dtNodes->count() === 0 || $ddNodes->count() === 0) {
                        return;
                    }

                    $titles = $dtNodes->each(function (Crawler $dtNode) {
                        return $dtNode->text();
                    });

                    $values = $ddNodes->each(function (Crawler $ddNode) {
                        return $ddNode->text();
                    });

                    $tableData[] = array_combine($titles, $values);
                } catch (\Exception $e) {
                    $this->handleError($e);
                }
            });
            return $tableData;
        } catch (\Exception $e) {
            $this->handleError($e);
            return $tableData;
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
