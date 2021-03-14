<?php

namespace Tests\Unit;

use App\Http\Services\Filters\PlacesFilter;
use PHPUnit\Framework\TestCase;

class PlacesFilterTest extends TestCase
{
    public function test_filter_instance()
    {
        $filter = new PlacesFilter();
        $filter = $filter->name('Teste')->city('São Paulo');
        $this->assertEquals($filter->name, 'Teste');
        $this->assertEquals($filter->city, 'São Paulo');
    }

    public function test_filter_with_null_values() {
        $filter = new PlacesFilter();
        $filter = $filter->name(null)->city(null);
        $this->assertNull($filter->name);
        $this->assertNull($filter->city);
    }

    public function test_has_no_filter() {
        $filter = new PlacesFilter();
        $this->assertFalse($filter->hasFilter());
    }

    public function test_has_filter() {
        $filter = new PlacesFilter();
        $filter->name('Teste');
        $this->assertTrue($filter->hasFilter());
    }

}
