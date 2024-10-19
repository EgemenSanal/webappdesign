<?php

namespace Database\Factories;


use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['B','P','V']);
        $memberID = $this->faker->numberBetween(1,25);
        return [
            'memberID' => Member::factory(),
            'status' => $status,
            'billedDate' => $this->faker->dateTime(),
            'paidDate' => $status === 'P' ? $this->faker->dateTime() : null,
        ];
    }
}
