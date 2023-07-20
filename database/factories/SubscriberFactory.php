<?php

namespace Database\Factories;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'name' => fake()->name(),
            'state' => fake()->randomElement([
                Subscriber::STATE_ACTIVE,
                Subscriber::STATE_UNSUBSCRIBED,
                Subscriber::STATE_JUNK,
                Subscriber::STATE_BOUNCE,
                Subscriber::STATE_UNCONFIRMED,
            ]),
            'source' => fake()->randomElement([
                Subscriber::SOURCE_API,
                Subscriber::SOURCE_FORMS,
                Subscriber::SOURCE_IOS,
                Subscriber::SOURCE_WEB,
            ]),
        ];
    }
}
