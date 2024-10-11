<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),  // Generates a new user if not provided
            'amount' => $this->faker->numberBetween(100, 5000),
            'transaction_id' => $this->faker->unique()->uuid,
            'status' => $this->faker->randomElement(['completed', 'pending', 'failed']),
        ];
    }
}
