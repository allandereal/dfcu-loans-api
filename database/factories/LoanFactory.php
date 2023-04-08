<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'amount_disbursed' => $this->faker->randomNumber(4) * 1000,
            'outstanding_amount' => $this->faker->randomNumber(4) * 1000,
            'date_disbursed' => now()->subMonths($this->faker->randomNumber(2)),
            'due_date' => now()->addMonths($this->faker->randomNumber(2)),
        ];
    }

    public function paidOff(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'outstanding_amount' => 0,
            ];
        });
    }
}
