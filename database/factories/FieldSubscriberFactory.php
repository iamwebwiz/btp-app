<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FieldSubscriber>
 */
class FieldSubscriberFactory extends Factory
{
    public function definition()
    {
        return [
            'field_id' => Field::factory()->create()->id,
            'subscriber_id' => Subscriber::factory()->create()->id,
            'value' => fake()->words(3, true),
        ];
    }
}
