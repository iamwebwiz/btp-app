<?php

namespace Tests\Feature;

use App\Models\Field;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FieldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_list_of_available_fields(): void
    {
        Field::factory(3)->create();

        $response = $this->getJson('/api/fields');

        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_can_create_a_new_field(): void
    {
        $response = $this->postJson('/api/fields', ['title' => 'Country', 'type' => 'string']);

        $response->assertCreated();
        $this->assertDatabaseCount('fields', 1);
    }

    public function test_can_get_a_single_field_resource(): void
    {
        $field = Field::factory()->create();

        $response = $this->getJson("/api/fields/{$field->id}");

        $response->assertOk();
    }

    public function test_can_update_a_field_resource(): void
    {
        $field = Field::factory()->create();

        $response = $this->patchJson("/api/fields/{$field->id}", ['title' => 'Company', 'type' => 'string']);

        $response->assertSuccessful();
        $this->assertDatabaseHas('fields', ['title' => 'Company']);
    }

    public function test_can_delete_a_field_resource(): void
    {
        $field = Field::factory()->create();

        $response = $this->deleteJson("/api/fields/{$field->id}");

        $field->refresh();

        $response->assertSuccessful();
        $this->assertNotNull($field->deleted_at);
    }
}
