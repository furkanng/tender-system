<?php

namespace App\Service\Autogong;

use App\Jobs\Autogong\ArchiveJob;
use App\Models\Archive;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

trait GetArchiveTrait
{
    public function getArchive($page)
    {
        $response = $this->client->request("GET", self::ARSIV_URL . "?per_page=$page", [
            'timeout' => 20,
            'cookies' => $this->jar,
        ])->getBody()->getContents();


        return $this->parseArchiveData($response);
    }

    public function parseArchiveData($html)
    {
        $crawler = new Crawler($html);

        $productTitles = $crawler->filterXpath('//div[@class="arsiv-row content-width"]')->each(function ($node) {
            $text = $node->text();
            $data = trim(str_replace("&nbsp", "", $text));

            $pattern = '/Araç No : (\d+) Plaka : ([A-Z0-9]+) Araç : (.+) Model : (\d+) İl : (.+) Tarih : (.+) Sıra : (\d+) Teklif : (\d+(?:\.\d+)?) ₺ Kazanan Teklif : (\d+(?:\.\d+)?) ₺ Durum : ([^:]+)/u';

            preg_match($pattern, $data, $matches);
            if (count($matches) >= 10) {
                $kazananTeklif = trim($matches[9]);
                $durum = trim($matches[10]);

                // Eğer "Durum" değeri "KAYBETTİNİZ Durum" gibi bir hata içeriyorsa, bu hatayı düzeltebilirsiniz.
                $durum = str_replace(" Durum", "", $durum);

                return [
                    "firmaId" => 1,
                    'ihaleNo' => $matches[1],
                    'plaka' => $matches[2],
                    'arac' => $matches[3],
                    'sehir' => $matches[5],
                    'tarih' => $matches[6],
                    'sira' => $matches[7],
                    'teklifim' => $matches[8],
                    'kazananTeklif' => $kazananTeklif,
                    'durum' => $durum,
                ];
            } else {
                \Log::error("Hatalı veri: " . $data);
                return null;
            }


        });

        $this->dataArchiveControl(array_filter($productTitles));

        return $productTitles;
    }

    public function dataArchiveControl($productTitles)
    {
        foreach ($productTitles as $product) {
            // Veritabanında ilgili AracNo'ya sahip kaydı ara
            $existingRecord = Archive::where('tender_no', $product['ihaleNo'])->first();

            $teklif = Bid::where('company_id', 1)->where('tender_id', $product['ihaleNo'])
                ->where('transfer_status', '1')->first();

            if ($teklif !== null) {
                $teklifVeren = User::where('id', $teklif->user_id)->first();
                $product['teklifVerenIsim'] = $teklifVeren->name;
                $product['teklifVerenNo'] = $teklifVeren->phone;
            }

            if ($existingRecord) {
                // Veri tabanında kayıt var, güncelleme yapılması gerekiyor mu kontrol et
                if ($existingRecord->status != $product['durum'] || $existingRecord->my_bid != $product['teklifim']) {
                    // Kayıt güncellenmeli, örneğin:
                    $existingRecord->status = $product['durum'];
                    $existingRecord->my_bid = $product['teklifim'];
                    $existingRecord->bid_win = $product['kazananTeklif'];
                    $existingRecord->save();
                    // Loglama
                    \Log::info('Kayıt güncellendi: ' . $existingRecord->id);
                }
            } else {
                // Veritabanında kayıt yok, yeni kayıt oluştur
                DB::table("archives")->insert([
                    "company_id" => 1,
                    "company_name" => "Autogong",
                    'tender_no' => $product['ihaleNo'],
                    'plate' => $product['plaka'],
                    'car' => $product['arac'],
                    'city' => $product['sehir'],
                    'date' => $product['tarih'],
                    'order' => $product['sira'],
                    'my_bid' => $product['teklifim'],
                    'bid_win' => $product['kazananTeklif'],
                    'status' => $product['durum'],
                    'created_at' => now(),
                ]);
                // Loglama
                \Log::info('Yeni kayıt oluşturuldu: ' . $product['ihaleNo']);
            }


        }
    }

    public function archiveSave()
    {
        $startPage = 1;
        $endPage = 40;

        for ($page = $startPage; $page <= $endPage; $page++) {
            ArchiveJob::dispatch($page);
        }
    }
}
