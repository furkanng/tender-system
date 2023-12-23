<?php

namespace App\Service\Otopert;

use App\Models\Company;
use App\Models\Tender;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Jobs\Otopert\TenderLiteJob;
use App\Models\Archive;

class OtopertService
{
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

        $user = Company::findOrFail("2");
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

        //dd($response);

        /*
        if($result["result"] !== "success"){
            echo "firmaya login olunamadı";
            exit();
        }*/
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


    public function getAllCarsLite()
    {
        // Job Parameteres: $this->client, $this->jar 

        $response = $this->client->request("GET", self::TENDERS_URL_LITE, [
            "timeout" => 60,
            "cookies" => $this->jar
        ])
            ->getBody()->getContents();

        //$response=TenderLiteJob::dispatchSync($this->client,$this->jar);

        $crawler = new Crawler($response);

        $response = [];
        $crawler->filter('.b-goods-f h2')->each(function (Crawler $h2Node) use (&$response) {
            // H2 içindeki ilk a etiketinin href değerini alıyoruz
            $firstHrefValue = $h2Node->filter('a')->first()->attr('href');

            $desiredPart = str_replace('https://www.otopert.com.tr/arac-detay/', '', $firstHrefValue);


            $response[] = $this->getCarDetails($desiredPart);
        });

        $renamedArray = [];

        foreach ($response as $item) {
            $renamedItem = [
                'ModelYear' => $item['Model Yılı:'],
                'Brand' => $item['Modeli:'],
                'Gear' => $item['Vites:'],
                'Plate' => $item['Plaka:'],
                'Km' => $item['Km:'],
                'FuelType' => $item['Yakıt Türü:'],
                'Damage' => $item['Hasarı:'],
                'CarType' => $item['Araç Türü:'],
                'Name' => $item['Name'],
                'PlateStatus' => $item['Plaka Durumu:'],
                'ServiceType' => $item['Servis Türü:'],
                'ServiceCity' => $item['Servis İli:'],
                'ServiceTel' => $item['Servis Tel:'],
                'ServiceName' => $item['Servisin Adı:'],
                'TenderNo' => $item['TenderNo'],
                'TenderClosedDate' => $item['TenderClosedDate'],
                'Images' => $item['Images']

            ];

            $renamedArray[] = $renamedItem;
        }


        foreach ($renamedArray as $item) {

            $car = Tender::query()->where("tender_no", $item["TenderNo"])->first();

            if (!$car) {
                DB::table("tenders")->insert([
                    'company_id' => 2,
                    'tender_no' => $item['TenderNo'],
                    'plate' => $item['Plate'],
                    'name' => $item['Name'],
                    'brand' => $item['Brand'],
                    //'model' => $item['model'],
                    'year' => $item['ModelYear'],
                    'km' => $item['Km'],
                    'fuel_type' => $item['FuelType'],
                    //'roll' => $item['silindir'],
                    //'tsrsb' => $item['tsrsbBedeli'],
                    'gear' => $item['Gear'],
                    //'sase_no' => $item['shaseNo'],
                    'car_type' => $item['CarType'],
                    //'images' => $item['images'],
                    'serviceName' => $item["ServiceName"],
                    //'address' => $item["ServiceCity"],
                    'servicePhone' => $item["ServiceTel"],
                    'city' => $item["ServiceCity"],
                    'district' => $item["ServiceType"],
                    'damages' => $item['Damage'],
                    'closed_date' => $item['TenderClosedDate'],
                    'images' => $item['Images'],
                    'created_at' => now(),
                ]);
            }
        }
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
        //dd($carImagesEncoded);

        $fullContent = $targetDiv->text();
        $dateInfo = str_replace(['İhale Bitiş Tarihi:', ' 50:14:46'], '', $fullContent);
        $dateInfo = trim($dateInfo);
        $dateInfo = str_replace(
            ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
            ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            $dateInfo
        );

        $dateTime = Carbon::createFromFormat('d F Y', $dateInfo);
        $lastDateTime = $dateTime->format('d.m.Y');

        //TenderLiteJob::dispatchSync($crawler);
        $carDetails = $this->getCarDetailData($crawler);

        //dd($carDetails);

        $carDetails[0]['Name'] = $carName;
        $carDetails[0]['TenderNo'] = $desiredPart;
        $carDetails[0]['TenderClosedDate'] = $lastDateTime;
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
        /*
        DB::table('tenders')->insert([
            "company_id"=>2,
            ''
        ])*/
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

    public function getArchiveData()
    {
        $response = $this->client->request("GET", self::ARCHIVES, [
            "timeout" => 60,
            "cookies" => $this->jar
        ])->getBody()->getContents();

        $crawler = new Crawler($response);

        $tableRows = $crawler->filter('table.table.table-hover tbody tr');

        // Her satır için bilgileri al
        $tableData = [];
        $tableRows->each(function (Crawler $row)  use (&$tableData) {
            // Bilgileri ekrana yazdırabilir veya başka bir işlem yapabilirsiniz
            $vehicleUrl = $row->filter('td:nth-child(2) a')->attr('href');
            $tenders_no = str_replace('https://www.otopert.com.tr/arac-detay/', '', $vehicleUrl);


            $vehicleNumber = $row->filter('td:nth-child(1)')->text();
            $vehicleName = $row->filter('td:nth-child(2) a')->text();
            $tenderFinishDate = $row->filter('td:nth-child(3)')->text();
            $plate = $row->filter('td:nth-child(4)')->text();
            $yourOrder = $row->filter('td:nth-child(5)')->text();
            $yourBid = $row->filter('td:nth-child(6)')->text();
            $highestBid = $row->filter('td:nth-child(7)')->text();
            $status = $row->filter('td:nth-child(8) b')->text();

            $tableData[] = [
                'tender_no' => $tenders_no,
                'car' => $vehicleName,
                'date' => $tenderFinishDate,
                'plate' => $plate,
                'order' => $yourOrder,
                'my_bid' => $yourBid,
                'status' => $status,
                'bid_win' => $highestBid
            ];
        });


        foreach ($tableData as  $item) {

            $existingRecord = Archive::where('tender_no', $item['tender_no'])->first();
            if ($existingRecord) {

                $statusInDatabase = $existingRecord->status;
                $myBidInDatabase = $existingRecord->my_bid;
                $bigWinInDatabase = $existingRecord->big_win;

                // Değerleri karşılaştır ve güncelleme yap
                if ($item['status'] != $statusInDatabase) {
                    $existingRecord->status = $item['status'];
                }

                if ($item['my_bid'] != $myBidInDatabase) {
                    $existingRecord->my_bid = $item['my_bid'];
                }

                if ($item['bid_win'] != $bigWinInDatabase) {
                    $existingRecord->bid_win = $item['bid_win'];
                }

                // Değişiklik varsa kaydı güncelle
                if ($existingRecord->isDirty()) {
                    $existingRecord->save();
                }
            } else {


                DB::table('archives')->insert([
                    'company_id' => 2,
                    'tender_no' => $item['tender_no'],
                    'plate' => $item['plate'],
                    'car' => $item['car'],
                    'date' => $item['date'],
                    'order' => $item['order'],
                    'my_bid' => $item['my_bid'],
                    'status' => $item['status'],
                    'bid_win' => $item['bid_win'],
                    'created_at' => now()

                ]);
            }
        }
    }
}
