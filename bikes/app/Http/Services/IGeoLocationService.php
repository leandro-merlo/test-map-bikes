<?php

namespace App\Http\Services;

interface IGeoLocationService {
    function latitude();
    function longitude();
    function isValid() : bool;
}
