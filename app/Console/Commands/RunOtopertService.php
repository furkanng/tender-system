<?php

namespace App\Console\Commands;

use App\Service\Otopert\OtopertService;
use Illuminate\Console\Command;

class RunOtopertService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:runOtopert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Otopert Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new OtopertService();
        $service->getAllCarsLite();
        sleep(60);
        $service->getArchiveData();
    }
}
