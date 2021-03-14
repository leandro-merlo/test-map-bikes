<?php

namespace App\Models;

use App\Http\Services\IGeoLocationService;
use App\Http\Services\PlacesService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'country',
        'latitude',
        'longitude',
        'free_bikes'
    ];

    public function getDistanceAttribute() {
        $placeService = resolve(PlacesService::class);
        $geoLocationService = resolve(IGeoLocationService::class);
        return $placeService->distance($geoLocationService->longitude(), $geoLocationService->latitude(), $this->longitude, $this->latitude);
    }

}
