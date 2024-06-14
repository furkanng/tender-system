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

    protected $car;

    /**
     * Create a new job instance.
     */
    public function __construct($car)
    {
        $this->car = $car;
    }

    /**
     * Execute the job.
     */
    public function handle(OtopertService $otopertService)
    {
        try {

            $detail = $otopertService->getCarDetails($this->car);
            
            

            $item = [
                'ModelYear' => $detail['Model Yılı:'] ?? null,
                'Brand' => $detail['Modeli:'] ?? null,
                'Gear' => $detail['Vites:'] ?? null,
                'Plate' => $detail['Plaka:'] ?? null,
                'Km' => $detail['Km:'] ?? null,
                'FuelType' => $detail['Yakıt Türü:'] ?? null,
                'Damage' => $detail['Hasarı:'] ?? null,
                'CarType' => $detail['Araç Türü:'] ?? null,
                'Name' => $detail['Name'] ?? null,
                'PlateStatus' => $detail['Plaka Durumu:'] ?? null,
                'ServiceType' => $detail['Servis Türü:'] ?? null,
                'ServiceCity' => $detail['Servis İli:'] ?? null,
                'ServiceTel' => $detail['Servis Tel:'] ?? null,
                'ServiceName' => $detail['Servisin Adı:'] ?? null,
                'TenderNo' => $detail['TenderNo'] ?? null,
                'TenderClosedDate' => $detail['TenderClosedDate'] ?? null,
                'Images' => $detail['Images'] ?? null,
                'CarBidId'=>$detail['CarBidId'] ?? null
            ];

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
                        'service_name' => $item["ServiceName"],
                        'service_phone' => $item["ServiceTel"],
                        'city' => $item["ServiceCity"],
                        'service_type' => $item["ServiceType"],
                        'tender_doc' => $item["PlateStatus"],
                        'damages' => $item['Damage'],
                        'closed_date' => $item['TenderClosedDate'],
                        'images' => $item['Images'],
                        'car_bid_id'=>$item['CarBidId'],
                        'created_at' => now(),
                    ]);
                }
            } catch (\Exception $e) {
                $this->handleError($e);
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
