<?php

namespace App\Service\Autogong;

use App\Jobs\Autogong\ArchiveJob;
use App\Models\Archive;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

trait GetArchiveTrait
{
    public function getArchives()
    {
        for ($page = self::ARCHIVE_FIRST_PAGE; $page <= self::ARCHIVE_LAST_PAGE; $page++) {
            ArchiveJob::dispatchSync($page);
        }
    }

    public function getArchivePage($page)
    {
        $response = $this->client->request("GET", self::ARSIV_URL . "?per_page=$page", [
            'timeout' => 60,
            'cookies' => $this->jar,
        ])->getBody()->getContents();


        $this->parseArchiveData($response);
    }

    public function parseArchiveData($html)
    {
        $crawler = new Crawler($html);

        $cars = $crawler->filterXpath('//div[@class="arsiv-row content-width"]')->each(function ($node) {
            $text = $node->text();
            $data = trim(str_replace("&nbsp", "", $text));

            $pattern = '/Araç No : (\d+) Plaka : ([A-Z0-9]+) Araç : (.+) Model : (\d+) İl : (.+) Tarih : (.+) Sıra : (\d+) Teklif : (\d+(?:\.\d+)?) ₺ Kazanan Teklif : (\d+(?:\.\d+)?) ₺ Durum : ([^:]+)/u';

            preg_match($pattern, $data, $matches);
            if (count($matches) >= 10) {
                $kazananTeklif = trim($matches[9]);
                $durum = trim($matches[10]);

                // Eğer "Durum" değeri "KAYBETTİNİZ Durum" gibi bir hata içeriyorsa, bu hatayı düzeltebilirsiniz.
                $durum = str_replace(" Durum", "", $durum);

                $parts = explode(' IP:', $matches[6]);
                if (count($parts) > 1) {
                    $timeString = trim($parts[0]);
                } else {
                    $timeString = $matches[6];
                }

                // Zaman dizesini tarih ve saat kısmından ayırın
                $dateParts = explode(' ', $timeString);
                $dateOnly = $dateParts[0];

                // Carbon nesnesi oluşturun
                $date = Carbon::createFromFormat('d.m.Y', $dateOnly);

                return [
                    "company_id" => 1,
                    'tender_no' => $matches[1],
                    'plate' => $matches[2],
                    'car' => $matches[3],
                    'city' => $matches[5],
                    'date' => $date->getTimestamp(),
                    'order' => $matches[7],
                    'my_bid' => $matches[8],
                    'bid_win' => $kazananTeklif,
                    'status' => $durum,
                ];
            } else {
                \Log::error("Hatalı veri: " . $data);
                return null;
            }


        });

        $this->archiveSave(array_filter($cars));
    }

    public function archiveSave($cars)
    {
        foreach ($cars as $car) {

            $existingRecord = Archive::where('tender_no', $car['tender_no'])->first();

            if (!$existingRecord) {
                DB::table("archives")->insert([
                    "company_id" => 1,
                    'tender_no' => $car['tender_no'],
                    'plate' => $car['plate'],
                    'car' => $car['car'],
                    'city' => $car['city'],
                    'date' => $car['date'],
                    'order' => $car['order'],
                    'my_bid' => $car['my_bid'],
                    'bid_win' => $car['bid_win'],
                    'status' => $car['status'],
                    'created_at' => now(),
                ]);
            }
        }
    }
}
