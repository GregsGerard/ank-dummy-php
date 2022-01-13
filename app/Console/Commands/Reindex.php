<?php

namespace App\Console\Commands;

use App\Models\Film;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Reindex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reindex {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reindex information to elasticsearhc';

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
//        $client = ClientBuilder::create()->build();
        $hosts = [
            'http://ank-elastic:9200',       // HTTP Basic Authentication
        ];


        $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();

        $counter = 0;
        if ('film' === $this->argument('index')) {
            Film::chunk(100, function ($films) use ($client, &$counter) {
                    $films->each(function ($film) use ($client, &$counter) {
                        $params = [
                            'index' => 'films',
                            'id'    => 'my_id',
                            'body'  => $film->toArray()
                        ];
                        $counter++;
                        $client->index($params);
                    });

                    Log::info(sprintf('We have indexed %s films', $counter));
                });
        }


        return 0;
    }
}
