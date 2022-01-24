<?php

namespace Modules\CrmAutoCar\Console\Commands;

use Illuminate\Console\Command;
use Modules\CrmAutoCar\Contracts\Repositories\ShekelRepositoryContract;

class ShekelToEurCommand extends Command
{
    protected $signature = 'shekel:run';

    protected $description = 'Command description';

    public function handle()
    {


        $req_url = 'https://v6.exchangerate-api.com/v6/e8a7371cf31d06606b3be8ca/latest/ILS';
        $response_json = file_get_contents($req_url);

        if (false !== $response_json) {
            try {
                $response = json_decode($response_json);
                if ('success' === $response->result) {

                   app(ShekelRepositoryContract::class)->create($response->conversion_rates->EUR);


                }
            } catch (Exception $e) {

            }

        }

    }

}
