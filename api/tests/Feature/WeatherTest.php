<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class WeatherApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_weather()
    {
        $user = User::factory()->create();
        $response = $this->getJson("/users/{$user->id}/weather");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['weather', 'wind', 'main']]);
    }

    public function test_get_weather_with_external_api_error()
    {
        $user = User::factory()->create();
        config(['services.openweathermap.api_key' => 'invalid-api-key']);
        $response = $this->getJson("/users/{$user->id}/weather");
        $response->assertStatus(500);
    }
}