<?php

namespace Database\Seeders;

use App\Models\Definition;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExampleDefinitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $definitions = [
            ['name' => 'Berita Acara Negosiasi'],
            ['name' => 'Berita Acara Penjelasan Teknis'],
            ['name' => 'Risalah Negosiasi'],
            ['name' => 'Risalah Penjelasan Teknis'],
            ['name' => 'GCG'],
            ['name' => 'Penawaran Harga'],
            ['name' => 'RAB Final'],
            ['name' => 'Berita Acara Peninjauan Lapangan'],
            ['name' => 'Proses Pembayaran'],
            ['name' => 'Lain-lain'],
        ];

        foreach ($definitions as $definition) {
            Definition::create($definition);
        }
    }
}
