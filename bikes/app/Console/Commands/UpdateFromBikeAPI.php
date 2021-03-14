<?php

namespace App\Console\Commands;

use App\Http\Services\BikeApiConsumerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateFromBikeAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bikes:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update database from Bike API - http://api.citybik.es/';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('down');
        BikeApiConsumerService::getBrazilianPlaces();
        Artisan::call('up');
    }
}
