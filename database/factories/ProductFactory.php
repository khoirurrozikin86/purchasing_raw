<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProductFactory extends Factory
{
    // protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => '',
            'product_code' => fake()->phoneNumber(),
            'product_name' => fake()->name(),
            'product_spesification' => fake()->text(),
            'product_category_id' => 1,
            'product_color_id' => 103094,
            'product_allocation_id' => 1,
            'product_size' => 0,
            'product_group' => 0,
            'product_unit' => 0,
            'product_price' => 0,
            'product_stock' => 0,
          
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        // return $this->state(fn (array $attributes) => [
        //     'email_verified_at' => null,
        // ]);
    }
}
