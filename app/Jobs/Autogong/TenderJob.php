<?php

namespace App\Jobs\Autogong;

use App\Models\Tender;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class TenderJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $html;

    /**
     * Create a new job instance.
     */
    public function __construct($html)
    {
        $this->html = $html;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $crawler = new Crawler($this->html);

        $numbers = $crawler->filterXpath('//div[@class="right"]')->each(function ($node) {
            $text = $node->text();

            $metin = trim(str_replace(" & nbsp", "", $text));

            $ihaleNo = '';
            $kapanisTarihi = '';
            $ihaleTipi = '';

            if (preg_match_all('/(İHALE NO : (\d+)|İHALE DURUMU : ([A-Z\s]+))/', $metin, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    if (!empty($match[2])) {
                        $ihaleNo = $match[2];
                    }
                    if (!empty($match[3])) {
                        $ihaleTipi = $match[3];
                    }
                }
            }


            if (preg_match('/KAPANIŞ TARİHİ : ([\d:. ]+)/', $metin, $matches)) {
                $kapanisTarihi = $matches[1];
                try {
                    list($tarihKismi, $saatKismi) = explode(" ", $kapanisTarihi);
                    $tarihParcalari = explode(".", $tarihKismi);

                    $guncellenmisTarih = $tarihParcalari[0] . "." . $tarihParcalari[1] . "." . date("Y") . " " . $saatKismi;
                } catch (\Exception) {

                }
            }
            if ($ihaleTipi == "A") {
                $ihaleTipi = "AÇIK";
            }

            $closedDate = Carbon::parse($guncellenmisTarih ?? [])->timestamp;

            return [
                "ihaleNo" => $ihaleNo,
                "ihaleTipi" => $ihaleTipi,
                "kapanisTarihi" => $closedDate
            ];
        });

        $tenders = array_filter($numbers);

        $flatArray = [];

        foreach ($tenders as $subArray) {
            $flatArray[] = $subArray;
        }

        $sonuclar = array_filter($flatArray, function ($item) {
            return !empty($item["ihaleNo"]);
        });

        foreach ($sonuclar as $item) {
            DB::table("tenders")
                ->where('tender_no', $item["ihaleNo"])
                ->update([
                    'closed_date' => $item["kapanisTarihi"],
                    'tender_type' => $item["ihaleTipi"],
                ]);
        }

    }
}
