<?php

namespace App\Console\Commands;

use App\Models\Staff;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnonomizedClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anonimzed-client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Anonimized Client';

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
        $faker = Factory::create();
        $staffPeoples = Staff::all();

        $counter = 0;
        $staffPeoples->each(function (Staff $people) use ($faker) {
            $people->first_name = $faker->name;
            $people->last_name = $faker->name;
            $people->save();
            $counter++;
        });
        Log::info(sprintf('We have anonimzed %s staff users', $counter));
        return 0;
    }
}
