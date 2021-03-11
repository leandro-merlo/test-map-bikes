<?php

namespace Tests\Unit;

use App\Http\Services\BikeApiConsumerService;
use Tests\TestCase;

class BikeApiConsumerServiceTest extends TestCase
{

    public function test_hit_network_endpoint()
    {
        $this->assertEquals('200', BikeApiConsumerService::checkNetworksEndpoint());
    }

    public function test_get_networks_data() {
        $networks = BikeApiConsumerService::getNetworks();
        $this->assertIsArray($networks);
    }

    public function test_get_networks_parameterized_data() {
        $networks = BikeApiConsumerService::getNetworks(['id', 'location']);
        if ($networks) {
            $this->assertTrue(array_key_exists('id', $networks[0]));
            $this->assertTrue(array_key_exists('location', $networks[0]));
        }
    }

    public function test_get_brazilian_networks_only() {
        $networks = BikeApiConsumerService::getBrazilianNetworksData();
        $fail = false;
        foreach ($networks as $network) {
            if ($network['location']['country'] != 'BR') {
                $fail = true;
            }
        }
        $this->assertFalse($fail);
    }


}
