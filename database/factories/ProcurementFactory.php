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
            'name' => 'PEKERJAAN ' . strtoupper($this->faker->text(300, true)),
            'number' => $this->faker->regexify('[0-9]{4}-[2-3]{2}'),
            'receipt' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'division_id' => $this->faker->randomElement(Division::pluck('id')->toArray()),
            'official_id' => $this->faker->randomElement(Official::pluck('id')->toArray()),
            'status' => '0',
        ];
    }
}
