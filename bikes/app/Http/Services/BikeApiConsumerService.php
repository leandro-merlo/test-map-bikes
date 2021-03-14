<?php

namespace App\Http\Services;

use App\Models\Place;
use Illuminate\Support\Facades\Http;

class BikeApiConsumerService {

    const BASE_API_URL = 'http://api.citybik.es/';

    const NETWORKS_ENDPOINT = 'v2/networks';

    static public function checkNetworksEndpoint() : int {
        $response = Http::get(BikeApiConsumerService::BASE_API_URL . BikeApiConsumerService::NETWORKS_ENDPOINT);
        return $response->status();
    }

    static public function getNetworks(array $parameters = array()) : array {
        $queryString = '';
        if (!empty($parameters)) {
            $queryString = "?fields=" . implode(',', $parameters);
        }
        $response = Http::get(BikeApiConsumerService::BASE_API_URL . BikeApiConsumerService::NETWORKS_ENDPOINT . $queryString );
        return $response->collect()->get('networks');
    }

    static public function getBrazilianNetworksData(array $parameters = array()) : array {
        if (!empty($parameters) && !array_key_exists('location', $parameters)){
            $parameters[] = 'location';
        }
        $data = self::getNetworks($parameters);
        $data = collect($data)->reject(function($network){
            return $network['location']['country'] != 'BR';
        });
        if (!empty($parameters) && !array_key_exists('location', $parameters)) {
            $data = collect($data)->map(function($network){
                unset($network['location']);
                return $network;
            });
        }
        return $data->toArray();
    }

    static public function getBrazilianPlaces(){
        Place::truncate();
        $brazilianNetworks = self::getBrazilianNetworksData(['href']);
        $places = [];
        foreach ($brazilianNetworks as $bn) {
            $queryString = "?fields=stations,location,id";
            $response = Http::get(BikeApiConsumerService::BASE_API_URL . $bn['href'] . $queryString );
            $network = $response->collect()->get('network');
            $stations = $network['stations'];
            collect($stations)->map(function($station) use ($network, &$places) {
                // This avoids duplicated data
                $exists = Place::where('name', $station['name'])->first();
                $place_to_save = $exists ?? new Place();
                self::updatePlace($place_to_save, $station, $network);
                $place_to_save->save();
                $places[] = $place_to_save;
            });
        }
        return $places;
    }

    static private function updatePlace(Place &$place, $station, $network) {
        $place->name = $station['name'];
        $place->country = $network['location']['country'];
        $place->city = $network['location']['city'];
        $place->longitude = $station['longitude'];
        $place->latitude = $station['latitude'];
        $place->free_bikes = $station['free_bikes'];
    }
}
