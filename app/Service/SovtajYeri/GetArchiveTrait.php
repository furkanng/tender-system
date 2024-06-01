<?php

namespace App\Service\SovtajYeri;

use App\Models\Archive;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

trait GetArchiveTrait
{
    public function AllArchivesGet()
    {
        try {
            $response = $this->client->request("GET", self::ARCHIVE_URL, [
                'form_params' => [
                    'ref_no' => 1,
                ],
                'timeout' => 20,
                'cookies' => $this->jar,
            ])->getBody()->getContents();

            $this->getArchive($response);
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }

    public function getArchive($html)
    {
        try {
            $crawler = new Crawler($html);
            $data = [];

            $crawler->filter('tbody tr')->each(function (Crawler $node) use (&$data) {
                try {
                    $row = [];
                    $row['tender_no'] = trim($node->filter('td')->eq(2)->filter('a')->text());
                    $arac_bilgisi = $node->filter('td')->eq(3)->html();
                    $arac_bilgisi_parcalar = explode('<br>', $arac_bilgisi);
                    $row['plate'] = trim(strip_tags($arac_bilgisi_parcalar[0]));
                    $row['brand'] = trim($arac_bilgisi_parcalar[1]);
                    $row['model'] = trim($arac_bilgisi_parcalar[2]);
                    $row['year'] = trim($node->filter('td')->eq(4)->text());
                    $row['bid_name'] = trim($node->filter('td')->eq(6)->text());
                    $row['order'] = rtrim(trim($node->filter('td')->eq(7)->filter('h5')->text()), '.');
                    $row['my_bid'] = trim($node->filter('td')->eq(8)->filter('h5')->text());
                    $row['bid_win'] = trim($node->filter('td')->eq(9)->filter('h5')->text());
                    $row['date'] = trim($node->filter('td')->eq(11)->filter('h5')->text());
                    $row['status'] = trim($node->filter('td')->eq(12)->filter('span')->text());

                    $data[] = $row;
                } catch (\Exception $e) {
                    $this->handleError($e);
                }
            });

            $this->archiveSave(array_filter($data));
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }

    public function archiveSave($data)
    {
        try {
            foreach ($data as $key) {
                $tender = Archive::query()->where("tender_no", $key["tender_no"])->first();
                if (!$tender) {
                    DB::table("archives")->insert([
                        'company_id' => 3,
                        'tender_no' => $key['tender_no'] ?? null,
                        'plate' => $key['plate'] ?? null,
                        'car' => $key['brand'] . " " . $key['model'] ?? null,
                        'year' => $key['year'] ?? null,
                        'date' => Carbon::parse($key['date'])->timestamp ?? null,
                        'status' => $key['status'] ?? null,
                        'order' => $key['order'] ?? null,
                        'bid_name' => $key['bid_name'] ?? null,
                        'my_bid' => $key['my_bid'] ?? null,
                        'bid_win' => $key['bid_win'] ?? null,
                        'created_at' => now(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            $this->handleError($e);
        }
    }
}
