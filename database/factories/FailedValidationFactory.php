<?php

namespace Database\Factories;

use App\Models\ApiRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FailedValidation>
 */
class FailedValidationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'api_request_id' => ApiRequest::factory(),
            'errors' => json_encode([
                "The account number must be a number.",
                "The account number must be 10 digits.",
            ])
        ];
    }
}
