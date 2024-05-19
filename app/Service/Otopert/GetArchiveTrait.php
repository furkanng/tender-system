<?php

namespace App\Service\Otopert;

use App\Models\Archive;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

trait GetArchiveTrait
{
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
        $tableRows->each(function (Crawler $row) use (&$tableData) {
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


        foreach ($tableData as $item) { W

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
                    'date' => Carbon::parse($item['date'] ?? [])->timestamp,
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
