<?php

namespace Database\Seeders;

use App\Models\Official;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExampleOfficialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $officials = [
            ['name' => 'RANGGA NOPARA', 'initials'=>'RN', 'status' => '1'],
            ['name' => 'EZA PRADILA PUTRI', 'initials'=>'EZA', 'status' => '1'],
            ['name' => 'ERYC PRANATA', 'initials'=>'EPP', 'status' => '1'],
        ];

        foreach ($officials as $official) {
            Official::create($official);
        }
    }
}
