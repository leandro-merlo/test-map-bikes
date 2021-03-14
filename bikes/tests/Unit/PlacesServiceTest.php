<?php

namespace Tests\Unit;

use App\Http\Services\PlacesService;
use App\Models\Place;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class PlacesServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_find()
    {
        $service = new PlacesService();
        $result = $service->find();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals(Place::count(), count($result));
    }
}
