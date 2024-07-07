<?php

namespace App\Service\SovtajYeri;

use App\Jobs\SovtajYeri\TenderDetailJob;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

trait GetTenderTrait
{
    public function AllCarsGet()
    {
        for ($page = self::TENDER_FIRST_PAGE; $page <= self::TENDER_LAST_PAGE; $page++) {
            try {
                $response = $this->client->request("GET", self::ALL_TENDERS . $page, [
                    'form_params' => [
                        'ref_no' => 1,
                        'page' => $page
                    ],
                    'timeout' => 20,
                    'cookies' => $this->jar,
                ])->getBody()->getContents();
                $urls = $this->parseTenderLinks($response);

                if (!empty($urls)) {

                    TenderDetailJob::dispatch($urls);
                }
            } catch (\Exception $e) {
                $this->handleError($e);
            }
        }
    }

    public function parseTenderLinks($html)
    {
        try {
            $crawler = new Crawler($html);

            $urls = $crawler->filter('tr')->each(function (Crawler $node) {
                $linkNode = $node->filter('a');

                if ($linkNode->count() > 0) {
                    $link = $linkNode->attr('href');


                    if (preg_match('/javascript:window\.open\(\'([^\']+)\'/', $link, $matches)) {
                        return $matches[1] ?? null;
                    } else {
                        Log::error("Hatalı veri: " . $link);
                    }
                }

                return null;
            });

            return array_filter($urls);
        } catch (\Exception $e) {
            $this->handleError($e);
            return [];
        }
    }

    public function getTenderDetail($url)
    {
        try {

            return $this->client->request("GET", self::URL . $url, [
                'timeout' => 20,
                'cookies' => $this->jar,
            ])->getBody()->getContents();
        } catch (\Exception $e) {
            $this->handleError($e);
            return null;
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
