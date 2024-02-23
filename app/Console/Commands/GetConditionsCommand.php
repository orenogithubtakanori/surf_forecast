<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use Illuminate\Support\Facades\Log;

use App\Models\Condition;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class GetConditionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-conditions-command';

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
            ['latlon'=>'35.31,139.54','location_id'=>1],
            ['latlon'=>'35.31,139.50','location_id'=>2],
            ['latlon'=>'35.31,139.47','location_id'=>3],
            ['latlon'=>'35.32,139.45','location_id'=>4],
            ['latlon'=>'35.32,139.43','location_id'=>5],
            ['latlon'=>'35.31,139.36','location_id'=>6],
            ['latlon'=>'35.31,139.32','location_id'=>7],
            ['latlon'=>'35.15,139.12','location_id'=>8],
        ];
        //return Command::SUCCESS;
        foreach($keys as $key){
            $method = "GET";

            $token = config('services.weatherapi.token');
            $url = "http://api.weatherapi.com/v1/marine.json?key=" . $token . "&q=" . $key['latlon'] . "&days=5";

            try{
                $client = new Client();
            } catch(ClientException $e){
                echo Psr7\Message::toString($e->getRequest());
                echo Psr7\Message::toString($e->getResponse());
            }

            $response = $client->request($method, $url);
            $data = $response->getBody();
            $data = json_decode($data, true);

            $location = $data['location'];

            foreach($data['forecast']['forecastday'][0]['hour'] as $conditionElement){
                $condition = new condition();
                $condition->latitude = $location['lat'];
                $condition->longitude = $location['lon'];
                $condition->date = $conditionElement['time'];
                $condition->wave_height = $conditionElement['swell_ht_mt'];
                $condition->wave_direction =  $conditionElement['swell_dir_16_point'];
                $condition->wind_speed =  $conditionElement['wind_mph'];
                $condition->wind_direction =  $conditionElement['wind_dir'];
                $condition->temperature =  $conditionElement['temp_c'];
                $condition->location_id = $key['location_id'];
                $condition->save();
            }
        }
    }
}
