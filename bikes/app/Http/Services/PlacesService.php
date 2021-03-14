<?php

namespace App\Http\Services;

use App\Http\Services\Filters\PlacesFilter;
use App\Models\Place;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PlacesService {

    public function find(?PlacesFilter $filter = NULL) : Collection {
        $data = null;
        if ($filter && $filter->hasFilter()) {
            $data = Place::where(function(Builder $query) use ($filter){
                if ($filter->name) {
                    $query->where('name', 'LIKE', "%$filter->name%");
                }
                if ($filter->city) {
                    $query->where('city', 'LIKE', "%$filter->city%");
                }
            })->get();
        } else {
            $data = Place::all();
        }
        return $data;
    }

    public function getNearestPlace() {
        /**
         * @var IGeoLocationService $geolocationService
         */
        $geolocationService = resolve(IGeoLocationService::class);
        if (!$geolocationService->isValid()) {
            return null;
        }
        $all = Place::all();
        $nearest = null;
        foreach ($all as $place) {
            if ($nearest) {
                if ($place->distance <= $nearest->distance) {
                    $nearest = $place;
                }
            } else {
                $nearest = $place;
            }
        }
        return $nearest;
    }

    private function toRad($number) {
        return $number * pi() / 100;
    }

    public function distance($lon1, $lat1, $lon2, $lat2) {
        $R = 6371; // Radius of the earth in km
        $dLat = $this->toRad($lat2-$lat1);  // functions in radians
        $dLon = $this->toRad($lon2-$lon1);
        $a = sin($dLat/(double)2) * sin($dLat/(double)2) +
             cos($this->toRad($lat1)) * cos($this->toRad($lat2)) *
             sin($dLon/(double)2) * sin($dLon/(double)2);
        $c = (double)2 * atan2(sqrt($a), sqrt(1-$a));
        $d = $R * $c; // Distance in km
        return $d;
    }
}
