<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use Illuminate\Support\Facades\Log;

use App\Models\table_api_test;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class GetConditionsCommand_test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-conditions-command_test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $keys = [
            ['latlon'=>'35.31,139.54'],
        ];
        //return Command::SUCCESS;
        foreach($keys as $key){
            $method = "GET";

            $token = config('services.weatherapi.token');
            $url = "http://api.weatherapi.com/v1/forecast.json?key=" . $token . "&q=" . $key['latlon'] ."&days=3";

            try{
                $client = new Client();
            } catch(ClientException $e){
                echo Psr7\Message::toString($e->getRequest());
                echo Psr7\Message::toString($e->getResponse());
            }

            $response = $client->request($method, $url);
            $data = $response->getBody();
            $data = json_decode($data, true);

            //dd($data['forecast']);
            //$location = $data['location'];

            foreach($data['forecast']['forecastday'] as $Elements){
                foreach($Elements['hour'] as $conditionElement){
                    $table_api_test = new table_api_test();
                    $table_api_test->datetime = $conditionElement['time'];
                    $table_api_test->wind_dir = $conditionElement['wind_dir'];
                    $table_api_test->save();
                }
            }
        }
    }
}
