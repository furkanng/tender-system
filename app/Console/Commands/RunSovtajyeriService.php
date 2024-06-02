<?php

namespace App\Console\Commands;

use App\Service\SovtajYeri\SovtajyeriService;
use Illuminate\Console\Command;

class RunSovtajyeriService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:runSovtajyeri';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Sovtajyeri Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new SovtajyeriService();
        $service->AllCarsGet();
        sleep(60);
        $service->AllArchivesGet();
    }
}
