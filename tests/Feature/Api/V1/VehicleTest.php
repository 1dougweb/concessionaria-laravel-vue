<?php

namespace Tests\Feature\Api\V1;

use App\Domain\Vehicles\Models\Vehicle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_vehicles(): void
    {
        $user = User::factory()->create();
        Vehicle::factory()->count(2)->create();

        $response = $this->actingAs($user, 'api')->getJson('/api/v1/vehicles');

        $response->assertOk();
    }
}

