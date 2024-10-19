<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();
        $password = $this->faker->password();
        $hashedpassword  = Hash::make($password);
        $role = $this->faker->randomElement(['A','C','O']);

        return [
            'name' => $name,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $hashedpassword,
            'role' => $role,
        ];
    }
}
