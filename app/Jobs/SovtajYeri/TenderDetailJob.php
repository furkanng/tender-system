<?php

namespace App\Jobs\SovtajYeri;

use App\Models\Tender;
use App\Service\SovtajYeri\SovtajyeriService;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class TenderDetailJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $urls;

    /**
     * Create a new job instance.
     */
    public function __construct($urls)
    {
        $this->urls = $urls;
    }

    /**
     * Execute the job.
     */
    public function handle(SovtajyeriService $sovtajyeriService)
    {
        foreach ($this->urls as $url) {
            try {
                $html = $sovtajyeriService->getTenderDetail($url);

                $crawler = new Crawler($html);
                $details = [];

                $details['tender_no'] = $crawler->filter('.panel-container .row .col-md-6 h2 span.text-primary')->eq(1)->text();
                $details['brand'] = $crawler->filterXPath('//small[contains(text(),"Marka")]/following-sibling::text()')->text();
                $details['year'] = $crawler->filterXPath('//small[contains(text(),"Model Yılı")]/following-sibling::text()')->text();
                $year = $details['year'];
                $details['model'] = trim($crawler->filterXPath('//small[contains(text(),"Model")]/following-sibling::text()[normalize-space() and not(contains(.,"' . $year . '"))]')->text());
                $details['plate'] = $crawler->filterXPath('//small[contains(text(),"Plaka")]/following-sibling::text()')->text();
                $details['km'] = $crawler->filterXPath('//small[contains(text(),"KM")]/following-sibling::text()')->text();
                $details['sase_no'] = $crawler->filterXPath('//small[contains(text(),"Şasi No")]/following-sibling::text()')->text();
                $details['color'] = $crawler->filterXPath('//small[contains(text(),"Renk")]/following-sibling::text()')->text();
                $details['car_type'] = $crawler->filterXPath('//small[contains(text(),"Kullanım Türü")]/following-sibling::text()')->text();
                $details['damages'] = $crawler->filterXPath('//small[contains(text(),"Hasar Şekli")]/following-sibling::text()')->text();
                $details['gear'] = $crawler->filterXPath('//small[contains(text(),"Vites")]/following-sibling::text()')->text();
                $details['fuel_type'] = $crawler->filterXPath('//small[contains(text(),"Yakıt")]/following-sibling::text()')->text();
                $details['tender_doc'] = trim($crawler->filterXPath('//small[contains(text(),"Belge Türü")]/following-sibling::span[normalize-space()]')->text());
                $details['tender_type'] = $crawler->filterXPath('//small[contains(text(),"İhale Modeli")]/following-sibling::text()')->text();
                $details['closed_date'] = $crawler->filterXPath('//label[contains(text(),"İhale Bitiş Tarihi")]/following-sibling::span')->text();
                $details['service_name'] = $crawler->filterXPath('//small[contains(text(),"Servis Adı")]/following-sibling::text()')->text();
                $details['service_type'] = $crawler->filterXPath('//small[contains(text(),"Servis Durumu")]/following-sibling::text()')->text();
                $details['service_phone'] = $crawler->filterXPath('//small[contains(text(),"Tel 1")]/following-sibling::text()')->text();
                $details['city'] = $crawler->filterXPath('//small[contains(text(),"Servis İl")]/following-sibling::text()')->text();
                $details['district'] = $crawler->filterXPath('//small[contains(text(),"Servis İlçe")]/following-sibling::text()')->text();
                $details['address'] = $crawler->filterXPath('//small[contains(text(),"Servis Adresi")]/following-sibling::text()')->text();

                $imageUrls = $crawler->filter('.carousel-inner .carousel-item img')->each(function (Crawler $node) {
                    $relativeUrl = $node->attr('src');
                    $baseUrl = 'https://ihale.sovtajyeri.com';
                    return $baseUrl . $relativeUrl;
                });

                $details['images'] = json_encode($imageUrls);

                DB::beginTransaction();
                try {
                    $car = Tender::query()->where("tender_no", $details["tender_no"])->first();

                    if (!$car) {
                        DB::table("tenders")->insert([
                            'company_id' => 3,
                            'tender_no' => $details['tender_no'] ?? null,
                            'name' => $details['brand'] . " " . $details['model'] ?? null,
                            'brand' => $details['brand'] ?? null,
                            'model' => $details['model'] ?? null,
                            'year' => $details['year'] ?? null,
                            'color' => $details['color'] ?? null,
                            'km' => $details['km'] ?? null,
                            'plate' => $details['plate'] ?? null,
                            'fuel_type' => $details['fuel_type'] ?? null,
                            'gear' => $details['gear'] ?? null,
                            'sase_no' => $details['sase_no'] ?? null,
                            'car_type' => $details['car_type'] ?? null,
                            'damages' => $details['damages'] ?? null,
                            'images' => $details['images'] ?? null,
                            'service_name' => $details['service_name'] ?? null,
                            'address' => $details['address'] ?? null,
                            'service_phone' => $details['service_phone'] ?? null,
                            'service_type' => $details['service_type'] ?? null,
                            'city' => $details['city'] ?? null,
                            'district' => $details['district'] ?? null,
                            'tender_doc' => $details['tender_doc'] ?? null,
                            'tender_type' => $details['tender_type'] ?? null,
                            'status' => 1,
                            'closed_date' => Carbon::parse($details['closed_date'])->timestamp ?? null,
                            'created_at' => now(),
                            'tender_url'=>$url
                        ]);
                    } else {
                        DB::table("tenders")->where("tender_no", $details['tender_no'])
                            ->update(['closed_date' => Carbon::parse($details['closed_date'])->timestamp]);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->handleError($e);
                }
            } catch (\Exception $e) {
                $this->handleError($e);
            }
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
