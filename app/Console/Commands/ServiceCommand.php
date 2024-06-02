<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:service-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new \App\Service\Autogong\AutogongService())->allCarsGet();
        sleep(90);
        (new \App\Service\Autogong\AutogongService())->getArchives();
        sleep(90);
        (new \App\Service\Otopert\OtopertService())->getAllCarsLite();
        sleep(90);
        (new \App\Service\Otopert\OtopertService())->getArchiveData();
        sleep(90);
        (new \App\Service\SovtajYeri\SovtajyeriService())->AllCarsGet();
        sleep(90);
        (new \App\Service\SovtajYeri\SovtajyeriService())->AllArchivesGet();
    }
}
