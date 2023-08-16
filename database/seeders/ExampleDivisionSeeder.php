<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExampleDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            ['name' => 'TEKNOLOGI INFORMASI', 'code'=>'TI', 'status' => '1'],
            ['name' => 'PELAYANAN DAN PEMELIHARAAN', 'code'=>'P&P', 'status' => '1'],
            ['name' => 'UMUM', 'code'=>'UMM', 'status' => '1'],
            ['name' => 'MANAJEMEN GERBANG TOL', 'code'=>'MGT', 'status' => '1'],
            ['name' => 'KEUANGAN', 'code'=>'KEU', 'status' => '1'],
            ['name' => 'SATUAN PENGAWAS INTERN', 'code'=>'SPI', 'status' => '1'],
            ['name' => 'SEKRETARIS PERUSAHAAN', 'code'=>'SPR', 'status' => '1'],
            ['name' => 'HUKUM', 'code'=>'HKM', 'status' => '1'],
            ['name' => 'AKUNTANSI', 'code'=>'AKT', 'status' => '1'],
            ['name' => 'TEKNIK DAN QUALITY ASSURANCE', 'code'=>'THK', 'status' => '1'],
            ['name' => 'INVESTASI', 'code'=>'INV', 'status' => '1'],
            ['name' => 'SUMBER DAYA MANUSIA', 'code'=>'SDM', 'status' => '1'],
            ['name' => 'HARBOUR ROUD (HBR) 2', 'code'=>'HBR2', 'status' => '1'],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
