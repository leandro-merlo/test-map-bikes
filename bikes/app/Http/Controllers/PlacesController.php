<?php

namespace App\Http\Controllers;

use App\Http\Services\Filters\PlacesFilter;
use App\Http\Services\IGeoLocationService;
use App\Http\Services\PlacesService;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    private PlacesService $service;
    private IGeoLocationService $geolocationService;

    public function __construct(PlacesService $service, IGeoLocationService $geolocationService) {
        $this->service = $service;
        $this->geolocationService = $geolocationService;
    }

    public function index() {
        $name_filter = request()->input('name');
        $city_filter = request()->input('city');
        $filter = new PlacesFilter();
        $filter = $filter->name($name_filter)->city($city_filter);
        $nearestPlace = $this->service->getNearestPlace($this->geolocationService->latitude(), $this->geolocationService->longitude());
        $data = [
            'places' => $this->service->find($filter),
            'filter' => [
                'name' => $filter->name ?? '',
                'city' => $filter->city ?? '',
            ]
        ];
        if ($nearestPlace) {
            $data['nearest'] = $nearestPlace;
        }
        return view("index", $data);
    }

}
