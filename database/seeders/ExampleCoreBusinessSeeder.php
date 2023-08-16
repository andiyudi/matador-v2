<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExampleCoreBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $corebusinesses = [
            ['name' => 'INFRASTRUKTUR', 'parent_id' => NULL],
            ['name' => 'MEKANIKAL & ELEKTRIKAL', 'parent_id' => NULL],
            ['name' => 'TEKNOLOGI INFORMASI', 'parent_id' => NULL],
            ['name' => 'KONSULTAN', 'parent_id' => NULL],
            ['name' => 'KANTOR JASA PENILAI PUBLIK', 'parent_id' => NULL],
            ['name' => 'SUPPLIER', 'parent_id' => NULL],
            ['name' => 'ASURANSI', 'parent_id' => NULL],
        ];

        foreach ($corebusinesses as $corebusiness) {
            Business::create($corebusiness);
        }
    }
}
