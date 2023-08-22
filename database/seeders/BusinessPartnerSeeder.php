<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessPartner;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusinessPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Business::whereNotNull('parent_id')->each(function ($business) {
            BusinessPartner::factory()->count(3)->create([
                'business_id' => $business->id,
            ]);
        });
    }
}
