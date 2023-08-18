<?php

namespace Database\Factories;

use App\Models\Division;
use App\Models\Official;
use App\Models\Procurement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Procurement>
 */
class ProcurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Procurement::class;

    public function definition(): array
    {
        return [
            'name' => 'Pekerjaan ' . $this->faker->word(),
            'number' => $this->faker->regexify('[0-9]{4}-[0-9]{2}'),
            'receipt' => $this->faker->date,
            'division_id' => $this->faker->randomElement(Division::pluck('id')->toArray()),
            'official_id' => $this->faker->randomElement(Official::pluck('id')->toArray()),
            'status' => '0',
        ];
    }
}
