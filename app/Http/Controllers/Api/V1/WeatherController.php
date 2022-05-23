<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\{City, WeatherReport};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Constants\ApiResponseCodes;
use Illuminate\Support\Facades\Log;

class  WeatherController extends Controller
{
    public function __construct() {
        $this->openWeatherApiKey = env('OPEN_WEATHER_API_KEY');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $cityName)
    {
        try {
            $city = City::where('name', $cityName)
            ->select('id')
            ->first();
            $cityId = $city->id ?? null;
            
            $weatherData = WeatherReport::where('city_name', $cityName)->first();

            if($weatherData) {
                $cityName = $weatherData->city_name;
                $latitude = $weatherData->lat;
                $longitude = $weatherData->lon;
                $weatherDescription = $weatherData->weather_description;
                $weatherIcon = $weatherData->weather_icon;
                $temperature = $weatherData->temperature;
                $minTemperature = $weatherData->min_temperature;
                $maxTemperature = $weatherData->max_temperature;
                $pressure = $weatherData->pressure;
                $humidity = $weatherData->humidity;
                $seaLevel = $weatherData->sea_level;
                $grndLevel = $weatherData->grnd_level;
                $country = $weatherData->country;
            } else {
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q=$cityName&appid=$this->openWeatherApiKey");
                $responseData = $response->json();

                if(!empty($responseData)) {
                    $id = $responseData['id'] ?? null;
                    $cityName = $responseData['name'] ?? null;
                    $latitude = $responseData['coord']['lat'] ?? null;
                    $longitude = $responseData['coord']['lon'] ?? null;
                    $weatherDescription = $responseData['weather'][0]['description'] ?? null;
                    $weatherIcon = $responseData['weather'][0]['icon'] ?? null;
                    $temperature = $responseData['main']['temp'] ?? null;
                    $minTemperature = $responseData['main']['temp_min'] ?? null;
                    $maxTemperature = $responseData['main']['temp_max'] ?? null;
                    $pressure = $responseData['main']['pressure'] ?? null;
                    $humidity = $responseData['main']['humidity'] ?? null;
                    $seaLevel = $responseData['main']['sea_level'] ?? null;
                    $grndLevel = $responseData['main']['grnd_level'] ?? null;
                    $country = $responseData['sys']['country'] ?? null;

                    if(empty($cityId)) {
                        $city = new City();
                        $city->name = $cityName;
                        $city->save();
                        $cityId = $city->id;
                    }
                    $weatherReport = new WeatherReport();
                    $weatherReport->city_id = $cityId;
                    $weatherReport->city_name = $cityName;
                    $weatherReport->lat = $latitude;
                    $weatherReport->lon = $longitude;
                    $weatherReport->weather_description = $weatherDescription;
                    $weatherReport->weather_icon = $weatherIcon;
                    $weatherReport->temperature = $temperature;
                    $weatherReport->min_temperature = $minTemperature;
                    $weatherReport->max_temperature = $maxTemperature;
                    $weatherReport->pressure = $pressure;
                    $weatherReport->humidity = $humidity;
                    $weatherReport->sea_level = $seaLevel;
                    $weatherReport->grnd_level = $grndLevel;
                    $weatherReport->country = $country;
                    $weatherReport->save();
                }                
            }

            return [
                "city_name" => $cityName,
                "coord" => [
                    'lat' => $latitude,
                    'lon' => $longitude,
                ],
                "weather" => [
                    'description' => $weatherDescription,
                    'icon' => $weatherIcon,
                ],
                "main" => [
                    'temp' => $temperature,
                    'min_temp' => $minTemperature,
                    'max_temp' => $maxTemperature,
                    'pressure' => $pressure,
                    'humidity' => $humidity,
                    'sea_level' => $seaLevel,
                    'grnd_level' => $grndLevel,
                    'country' => $country
                ]
            ];
        } catch(\Exception $e) {
            Log::error(get_class($this) . ".php Line no: " . $e->getLine() . " Error msg:" . $e->getMessage());
            return response()->json(['msg' => 'Something is really going wrong'], ApiResponseCodes::BAD_REQUEST);
        }
    }

    /**
     * Show five days weather report of a city
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fiveDaysWeather(Request $request, $cityName) {
        try {
            $response = Http::get("https://api.openweathermap.org/data/2.5/forecast?q=$cityName&appid=$this->openWeatherApiKey");
            $responseData = $response->json();

            return $responseData;
        } catch(\Exception $e) {
            Log::error(get_class($this) . ".php Line no: " . $e->getLine() . " Error msg:" . $e->getMessage());
            return response()->json(['msg' => 'Something is really going wrong'], ApiResponseCodes::BAD_REQUEST);
        }
    }
}