<?php

namespace App\Jobs\Autogong;

use App\Models\Tender;
use App\Service\Autogong\AutogongService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DetailJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $keys;

    /**
     * Create a new job instance.
     */
    public function __construct($keys)
    {
        $this->keys = $keys;
    }

    /**
     * Execute the job.
     */
    public function handle(AutogongService $autogongService)
    {
        try {
            $outputData = $autogongService->getCarsDetail($this->keys);

            $car = Tender::query()->where("tender_no", $outputData["tender_no"])->first();

            $data = [
                'company_id' => 1,
                'tender_no' => $outputData['tender_no'] ?? '',
                'closed_date' => $outputData['closed_date'] ?? '',
                'tender_doc' => $outputData['tender_doc'] ?? '',
                'plate' => $outputData['plate'] ?? '',
                'name' => ($outputData['brand'] ?? '') . ' ' . ($outputData['model'] ?? ''),
                'brand' => $outputData['brand'] ?? '',
                'model' => $outputData['model'] ?? '',
                'year' => $outputData['year'] ?? '',
                'km' => $outputData['km'] ?? '',
                'fuel_type' => $outputData['fuel_type'] ?? '',
                'roll' => $outputData['roll'] ?? '',
                'tsrsb' => $outputData['tsrsb'] ?? '',
                'gear' => $outputData['gear'] ?? '',
                'sase_no' => $outputData['sase_no'] ?? '',
                'car_type' => $outputData['car_type'] ?? '',
                'images' => $outputData['images'] ?? '',
                'service_name' => $outputData['service_name'] ?? '',
                'address' => $outputData['address'] ?? '',
                'service_phone' => $outputData['service_phone'] ?? '',
                'service_type' => $outputData['service_type'] ?? '',
                'city' => $outputData['city'] ?? '',
                'district' => $outputData['district'] ?? '',
                'damages' => $outputData['damages'] ?? '',
                'created_at' => now(),
            ];

            if (!$car) {
                DB::table("tenders")->insert($data);
            } else {
                DB::table("tenders")->where("tender_no", $outputData['tender_no'])
                    ->update([
                        'closed_date' => $outputData['closed_date'] ?? $car->closed_date,
                    ]);
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
