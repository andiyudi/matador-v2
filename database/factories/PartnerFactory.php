<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Partner::class;
    public function definition(): array
    {
        return [
            'name' => strtoupper($this->faker->company),
            'address' => $this->faker->address,
            'domicility' => $this->faker->address,
            'area' => $this->faker->city,
            'director' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'capital' => number_format($this->faker->numberBetween(100000000, 1000000000), 0, ',', '.'),
            'grade' => $this->faker->randomElement(['0', '1', '2']),
            'join_date' => now(),
            'reference' => $this->faker->name(),
            'status' => '0',
            'expired_at' => date('Y') . '-12-31',
        ];
    }
}
