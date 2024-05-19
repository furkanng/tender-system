<?php

namespace App\Jobs\Otopert;

use App\Models\Tender;
use App\Service\Otopert\OtopertService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class CarDetailJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $client;

    /**
     * Create a new job instance.
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Execute the job.
     */
    public function handle(OtopertService $otopertService)
    {
        try {
            $crawler = new Crawler($this->client);

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
                        $response[] = $otopertService->getCarDetails($part);
                    } catch (\Exception $e) {
                        $this->handleError($e);
                    }
                }
            }

            $renamedArray = [];

            foreach ($response as $item) {
                $renamedItem = [
                    'ModelYear' => $item['Model Yılı:'] ?? null,
                    'Brand' => $item['Modeli:'] ?? null,
                    'Gear' => $item['Vites:'] ?? null,
                    'Plate' => $item['Plaka:'] ?? null,
                    'Km' => $item['Km:'] ?? null,
                    'FuelType' => $item['Yakıt Türü:'] ?? null,
                    'Damage' => $item['Hasarı:'] ?? null,
                    'CarType' => $item['Araç Türü:'] ?? null,
                    'Name' => $item['Name'] ?? null,
                    'PlateStatus' => $item['Plaka Durumu:'] ?? null,
                    'ServiceType' => $item['Servis Türü:'] ?? null,
                    'ServiceCity' => $item['Servis İli:'] ?? null,
                    'ServiceTel' => $item['Servis Tel:'] ?? null,
                    'ServiceName' => $item['Servisin Adı:'] ?? null,
                    'TenderNo' => $item['TenderNo'] ?? null,
                    'TenderClosedDate' => $item['TenderClosedDate'] ?? null,
                    'Images' => $item['Images'] ?? null,
                ];

                $renamedArray[] = $renamedItem;
            }

            foreach ($renamedArray as $item) {
                try {
                    $car = Tender::query()->where("tender_no", rtrim($item['TenderNo'], '/'))->first();

                    if (!$car) {
                        DB::table("tenders")->insert([
                            'company_id' => 2,
                            'tender_no' => rtrim($item['TenderNo'], '/'),
                            'plate' => $item['Plate'],
                            'name' => $item['Name'],
                            'brand' => $item['Brand'],
                            'year' => $item['ModelYear'],
                            'km' => $item['Km'],
                            'fuel_type' => $item['FuelType'],
                            'gear' => $item['Gear'],
                            'car_type' => $item['CarType'],
                            'serviceName' => $item["ServiceName"],
                            'servicePhone' => $item["ServiceTel"],
                            'city' => $item["ServiceCity"],
                            'district' => $item["ServiceType"],
                            'damages' => $item['Damage'],
                            'closed_date' => $item['TenderClosedDate'],
                            'images' => $item['Images'],
                            'created_at' => now(),
                        ]);
                    }
                } catch (\Exception $e) {
                    $this->handleError($e);
                }
            }
        } catch (\Exception $e) {
            $this->handleError($e);
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
