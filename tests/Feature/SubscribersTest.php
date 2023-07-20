<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\FieldSubscriber;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_get_list_of_subscribers(): void
    {
        Subscriber::factory(3)->create();

        $response = $this->getJson('/api/subscribers');

        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_can_not_add_subscriber_with_invalid_email(): void
    {
        $response = $this->postJson('/api/subscribers', [
            'name' => $this->faker->name(),
            'email' => 'hello@example.io',
            'source' => Subscriber::SOURCE_API,
        ]);

        $response->assertUnprocessable()->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    public function test_can_add_new_subscriber_with_valid_email(): void
    {
        $response = $this->postJson('/api/subscribers', [
            'name' => $this->faker->name(),
            'email' => 'hello@gmail.com',
            'source' => Subscriber::SOURCE_API,
        ]);

        $response->assertCreated();
        $this->assertDatabaseCount('subscribers', 1);
    }

    public function test_can_not_get_invalid_subscriber(): void
    {
        $this->getJson('/api/subscribers/2')->assertJson(['message' => 'Subscriber does not exist'])->assertNotFound();
    }

    public function test_can_get_a_single_subscriber(): void
    {
        $subscriber = Subscriber::factory()->create();
        $field = Field::factory()->create();
        FieldSubscriber::create(['field_id' => $field->id, 'subscriber_id' => $subscriber->id, 'value' => 'test value']);

        $response = $this->getJson("/api/subscribers/{$subscriber->id}");

        $response->assertOk();
    }

    public function test_can_update_a_subscriber(): void
    {
        $subscriber = Subscriber::factory()->create();

        $response = $this->patchJson("/api/subscribers/{$subscriber->id}", [
            'name' => 'John Doe',
            'state' => Subscriber::STATE_ACTIVE,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('subscribers', ['name' => 'John Doe', 'state' => Subscriber::STATE_ACTIVE]);
    }

    public function test_can_upsert_fields_for_a_subscriber(): void
    {
        $subscriber = Subscriber::factory()->create();
        $field = Field::factory()->create();

        $response = $this->postJson("/api/subscribers/{$subscriber->id}/fields", [
            'fields' => [
                ['field_id' => $field->id, 'value' => 'hello there'],
            ]
        ]);

        $response->assertSuccessful()->assertCreated();
        $this->assertDatabaseCount('field_subscriber', 1);
        $this->assertDatabaseHas('field_subscriber', [
            'field_id' => $field->id,
            'subscriber_id' => $subscriber->id,
            'value' => 'hello there',
        ]);
    }

    public function test_can_delete_a_subscriber(): void
    {
        $subscriber = Subscriber::factory()->create();

        $response = $this->deleteJson("/api/subscribers/{$subscriber->id}");

        $subscriber->refresh();

        $response->assertSuccessful();
        $this->assertDatabaseHas('subscribers', [
            'id' => $subscriber->id,
            'state' => Subscriber::STATE_JUNK,
        ]);
        $this->assertNotNull($subscriber->deleted_at);
    }
}
