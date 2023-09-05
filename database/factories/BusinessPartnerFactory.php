<?php

namespace Database\Factories;

use App\Models\BusinessPartner;
use App\Models\Partner;
use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $partnerIds = Partner::pluck('id')->toArray();
        $businessIds = Business::whereNotNull('parent_id')->pluck('id')->toArray();

        $partnerId = $this->faker->randomElement($partnerIds);
        $businessId = $this->faker->randomElement($businessIds);

        $existingEntry = BusinessPartner::where('partner_id', $partnerId)
            ->where('business_id', $businessId)
            ->first();

        if (!$existingEntry) {
            return [
                'partner_id' => $partnerId,
                'business_id' => $businessId,
            ];
        }
        return [];
    }
}
