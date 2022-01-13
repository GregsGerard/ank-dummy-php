<?php

namespace App\Console\Commands;

use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

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

        $params = [
            'index' => 'my_index',
            'id'    => 'my_id',
            'body'  => ['testField' => 'abc']
        ];

        $response = $client->index($params);
        print_r($response);

        return 0;
    }
}
