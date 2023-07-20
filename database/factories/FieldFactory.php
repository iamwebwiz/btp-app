<?php

namespace Database\Factories;

use App\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Field>
 */
class FieldFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => fake()->word(),
            'type' => fake()->randomElement([
                Field::TYPE_STRING,
                Field::TYPE_NUMBER,
                Field::TYPE_BOOLEAN,
                Field::TYPE_DATE,
            ]),
        ];
    }
}
