<?php

namespace App\Console\Commands;
use App\Service\Autogong\AutogongService;


use Illuminate\Console\Command;

class RunAutogongService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:runAutogong';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Autogong Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new AutogongService();
        $service->allCarsGet();
        sleep(60);
        $service->getArchives();
    }
}
