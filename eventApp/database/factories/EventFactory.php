<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = $this->faker->company();
        $description = $this->faker->text();
        $location = $this->faker->address();
        $startingDate = $this->faker->dateTimeBetween('-2 years', 'now');
        $endingDate = $this->faker->dateTimeBetween($startingDate,'+2 years');
        $organizer_id = $this->faker->numberBetween(1,15);
        $capacity = $this->faker->numberBetween(4,20);
        $status = $this->faker->randomElement(['Active','Cancelled','Completed']);


        return [
            'name' => $name,
            'description' => $description,
            'location' => $location,
            'starting_date' => $startingDate,
            'ending_date' => $endingDate,
            'organizer_id' => $organizer_id,
            'capacity' => $capacity,
            'status' => $status,
        ];
    }
}
