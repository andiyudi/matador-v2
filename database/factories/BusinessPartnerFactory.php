<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\Business;
use App\Models\BusinessPartner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusinessPartner>
 */
class BusinessPartnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BusinessPartner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'partner_id' => Partner::inRandomOrder()->first(),
            'business_id' => Business::whereNotNull('parent_id')->inRandomOrder()->first(),
        ];
    }
}
