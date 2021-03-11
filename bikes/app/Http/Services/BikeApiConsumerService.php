<?php

namespace App\Http\Services;

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
        $brazilianNetworks = self::getBrazilianNetworksData(['href']);
        $places = [];
        foreach ($brazilianNetworks as $bn) {
            $queryString = "?fields=stations,location,id";
            $response = Http::get(BikeApiConsumerService::BASE_API_URL . $bn['href'] . $queryString );
            $network = $response->collect()->get('network');
            $stations = $network['stations'];
            foreach ($stations as $station) {
                $places[] = [
                    'city' => $network['location']['city'],
                    'country' => $network['location']['country'],
                    'latitude' => $station['latitude'],
                    'longitude' => $station['longitude'],
                    'name' => $station['name'],
                    'free_bikes' => $station['free_bikes']
                ];
            }
        }
        return $places;
    }
}
