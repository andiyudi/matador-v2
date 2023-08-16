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
            ['name' => 'Rangga Nopara', 'initials'=>'RN', 'status' => '1'],
            ['name' => 'Eza Pradila Putri', 'initials'=>'EZA', 'status' => '1'],
            ['name' => 'Eryc Pranata', 'initials'=>'EPP', 'status' => '1'],
        ];

        foreach ($officials as $official) {
            Official::create($official);
        }
    }
}
