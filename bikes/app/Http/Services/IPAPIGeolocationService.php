<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class IPAPIGeolocationService implements IGeoLocationService {

    private $longitude;
    private $latitude;

    public function __construct()
    {
        $details = $this->getDetailsFromIp(request()->ip());
        if ($details->status == 'fail') {
            $details = $this->getDetailsFromIp(request()->server('REMOTE_HOST'));
        }
        $this->latitude = $details->lat;
        $this->longitude = $details->lon;
    }

    private function getDetailsFromIp($ip) {
        $client = new Client();
        $response = $client->request('GET', "http://ip-api.com/json/$ip", [ 'verify' => false ]);
        return json_decode($response->getBody());
    }

    public function longitude() {
        return $this->longitude;
    }

    public function latitude() {
        return $this->latitude;
    }

    public function isValid() : bool {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }
}
