<?php

namespace App\Http\Services\Filters;

class PlacesFilter
{

    private $name;
    private $city;

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function name(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */
    public function city(?string $city)
    {
        $this->city = $city;
        return $this;
    }

    public function hasFilter() : bool {
        return $this->name || $this->city;
    }

    public function __get($property) {
        return $this->$property;
    }

}
