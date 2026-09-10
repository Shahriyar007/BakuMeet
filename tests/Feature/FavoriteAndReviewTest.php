<?php

namespace Tests\Feature;

use App\Models\Establishment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteAndReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_favorite_establishment(): void
    {
        $establishment = Establishment::factory()->create();
        $response = $this->post("/establishments/{$establishment->id}/favorite");
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_favorite_establishment(): void
    {
        $user = User::factory()->create();
        $establishment = Establishment::factory()->create();

        $response = $this->actingAs($user)->post("/establishments/{$establishment->id}/favorite");

        $response->assertRedirect();
        $this->assertTrue($user->favorites()->where('establishment_id', $establishment->id)->exists());
    }

    public function test_guest_cannot_submit_review(): void
    {
        $establishment = Establishment::factory()->create();

        $response = $this->post("/establishments/{$establishment->id}/reviews", [
            'comment' => 'Test yorum',
            'atmosphere_rating' => 5,
            'food_rating' => 5,
            'service_rating' => 5,
            'value_rating' => 5,
        ]);

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_submit_review(): void
    {
        $user = User::factory()->create();
        $establishment = Establishment::factory()->create();

        $response = $this->actingAs($user)->post("/establishments/{$establishment->id}/reviews", [
            'comment' => 'Harika bir yer',
            'atmosphere_rating' => 5,
            'food_rating' => 4,
            'service_rating' => 5,
            'value_rating' => 4,
        ]);

        $response->assertRedirect("/establishments/{$establishment->id}");
        $this->assertDatabaseHas('reviews', [
            'establishment_id' => $establishment->id,
            'user_id' => $user->id,
            'comment' => 'Harika bir yer',
        ]);
    }

    public function test_user_cannot_delete_another_users_review(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $establishment = Establishment::factory()->create();

        $review = Review::create([
            'user_id' => $owner->id,
            'establishment_id' => $establishment->id,
            'comment' => 'Sahibi bu',
            'rating' => 5,
            'atmosphere_rating' => 5,
            'food_rating' => 5,
            'service_rating' => 5,
            'value_rating' => 5,
        ]);

        $this->actingAs($intruder)->delete("/reviews/{$review->id}");

        $this->assertDatabaseHas('reviews', ['id' => $review->id]);
    }

    public function test_for_you_page_requires_auth(): void
    {
        $response = $this->get('/for-you');
        $response->assertRedirect('/login');
    }
}
