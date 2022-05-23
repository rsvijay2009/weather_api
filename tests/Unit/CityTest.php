<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityTest extends TestCase
{
    public function test_city_api_with_empty_data()
    {
        $response = $this->postJson('/api/v1/city', []);
        $response->assertStatus(422);
    }
}