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
        $outputData = $autogongService->getCarsDetail($this->keys) ?? null;

        $car = Tender::query()->where("tender_no", $outputData["tender_no"])->first();

        if (!$car) {
            DB::table("tenders")->insert([
                'company_id' => 1,
                'tender_no' => $outputData['tender_no'],
                'plate' => $outputData['plaka'],
                'name' => $outputData['name'],
                'brand' => $outputData['brand'],
                'model' => $outputData['model'],
                'year' => $outputData['modelYili'],
                'km' => $outputData['aracKM'],
                'fuel_type' => $outputData['yakit'],
                'roll' => $outputData['silindir'],
                'tsrsb' => $outputData['tsrsbBedeli'],
                'gear' => $outputData['vites'],
                'sase_no' => $outputData['shaseNo'],
                'car_type' => $outputData['aracTuru'],
                'images' => $outputData['images'],
                'serviceName' => $outputData['location']["ServisAdi"],
                'address' => $outputData['location']["Adres"],
                'servicePhone' => $outputData['location']["SabitTel"],
                'city' => $outputData['location']["il"],
                'district' => $outputData['location']["ilce"],
                'damages' => $outputData['damages'],
                'created_at' => now(),
            ]);
        }

    }
}
