<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type =$this->faker->randomElement(['DNI', 'RUC']);
        return [
            'document_number' => $type == 'DNI' ? $this->faker->unique()->numerify('########') : $this->faker->unique()->numerify('###########'),
            'type_document' =>  $type,
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
        ];
    }
}
