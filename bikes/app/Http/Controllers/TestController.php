<?php

namespace App\Http\Controllers;

use App\Http\Services\BikeApiConsumerService;
use App\Http\Services\Filters\PlacesFilter;
use App\Http\Services\IGeoLocationService;
use App\Http\Services\PlacesService;

class TestController extends Controller
{
    public function test(BikeApiConsumerService $service) {
        return response()->json($service->getBrazilianPlaces());
    }

    public function allPlaces(PlacesService $service) {
        $filter = new PlacesFilter;
        $filter->name('pam')->city('fort');
        $places = $service->find($filter);
        return response()->json($places);
    }

    public function nearest(PlacesService $service, IGeoLocationService $geoLocationService){
        if (!$geoLocationService->isValid()) {
            return response()->json([]);
        }
        $data = $service->getNearestPlace($geoLocationService->latitude(), $geoLocationService->longitude());
        return response()->json($data);
    }

}
