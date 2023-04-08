<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApiRequest>
 */
class ApiRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $numbers = range(0, 9);
        shuffle($numbers);

        return [
            'source_ip' => $this->faker->ipv4(),
            'type' => $this->faker->randomElement(['GET', 'POST', 'PUT', 'PATCH', 'DELETE']),
            'parameters' => json_encode(['account_number' => intval(implode('', $numbers))]),
            'status' => $this->faker->randomElement(['positive', 'negative']),
        ];
    }

    public function positive(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'positive',
                'type' => 'GET',
            ];
        });
    }

    public function negative(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'negative',
                'type' => 'GET',
            ];
        });
    }
}
