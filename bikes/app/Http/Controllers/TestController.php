<?php

namespace App\Http\Controllers;

use App\Http\Services\BikeApiConsumerService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(BikeApiConsumerService $service) {
        return response()->json($service->getBrazilianPlaces());
    }
}
