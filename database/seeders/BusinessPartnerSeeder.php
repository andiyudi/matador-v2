<?php

namespace Database\Seeders;

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
        $businessPartners = [
            ['partner_id' => 1, 'business_id' => 8],
            ['partner_id' => 2, 'business_id' => 8],
            ['partner_id' => 3, 'business_id' => 8],
            ['partner_id' => 4, 'business_id' => 8],
            ['partner_id' => 5, 'business_id' => 8],
            ['partner_id' => 6, 'business_id' => 9],
            ['partner_id' => 7, 'business_id' => 9],
            ['partner_id' => 8, 'business_id' => 9],
            ['partner_id' => 9, 'business_id' => 9],
            ['partner_id' => 10, 'business_id' => 9],
            ['partner_id' => 11, 'business_id' => 10],
            ['partner_id' => 12, 'business_id' => 10],
            ['partner_id' => 13, 'business_id' => 10],
            ['partner_id' => 14, 'business_id' => 10],
            ['partner_id' => 15, 'business_id' => 10],
            ['partner_id' => 16, 'business_id' => 11],
            ['partner_id' => 17, 'business_id' => 11],
            ['partner_id' => 18, 'business_id' => 11],
            ['partner_id' => 19, 'business_id' => 11],
            ['partner_id' => 20, 'business_id' => 11],
            ['partner_id' => 1, 'business_id' => 9],
        ];

        foreach ($businessPartners as $businessPartner) {
            BusinessPartner::create($businessPartner);
        }
    }
}
