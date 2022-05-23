<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Requests\CityRequest;
use App\Constants\ApiResponseCodes;

class CityController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $cityName = $request->city_name;
        if(City::where('name', $cityName)->exists()) {
            return response()->json(['msg' => 'The city is already created. Please try new one'], ApiResponseCodes::RESOURCE_CONFLICT);
        } else {
            $city = new City();
            $city->name = $request->city_name;
            $city->save();

            return response()->json(['msg' => 'City created successfully'], ApiResponseCodes::RESOURCE_CREATED);
        }
    }
}