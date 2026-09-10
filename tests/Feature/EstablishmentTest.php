<?php

namespace Tests\Feature;

use App\Models\Establishment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EstablishmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_establishments_index_loads(): void
    {
        Establishment::factory()->create();
        $response = $this->get('/establishments');
        $response->assertStatus(200);
    }

    public function test_establishment_show_page_loads(): void
    {
        $establishment = Establishment::factory()->create();
        $response = $this->get("/establishments/{$establishment->id}");
        $response->assertStatus(200);
        $response->assertSee($establishment->name);
    }

    public function test_establishment_show_returns_404_for_missing_id(): void
    {
        $response = $this->get('/establishments/999999');
        $response->assertStatus(404);
    }

    public function test_nearby_page_loads(): void
    {
        $response = $this->get('/nearby');
        $response->assertStatus(200);
    }

    public function test_wizard_page_loads(): void
    {
        $response = $this->get('/wizard');
        $response->assertStatus(200);
    }

    public function test_trending_page_loads(): void
    {
        $response = $this->get('/trending');
        $response->assertStatus(200);
    }

    public function test_weather_page_loads(): void
    {
        $response = $this->get('/weather');
        $response->assertStatus(200);
    }

    public function test_compare_page_requires_at_least_two_establishments(): void
    {
        $establishment = Establishment::factory()->create();
        $response = $this->get("/compare?ids[]={$establishment->id}");
        $response->assertStatus(200);
        $response->assertSee('en az 2 mekan');
    }
}
