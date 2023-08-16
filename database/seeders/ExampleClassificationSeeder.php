<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExampleClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classifications = [
            ['parent_id' => 1, 'name' => 'ASPAL'],
            ['parent_id' => 1, 'name' => 'GROUTING'],
            ['parent_id' => 1, 'name' => 'INJEKSI'],
            ['parent_id' => 1, 'name' => 'PATCHING'],
            ['parent_id' => 1, 'name' => 'MARKA'],
            ['parent_id' => 1, 'name' => 'RIGID PAVEMENT'],
            ['parent_id' => 1, 'name' => 'PENGECATAN'],
            ['parent_id' => 1, 'name' => 'ELEKTRIKAL JALAN TOL'],
            ['parent_id' => 1, 'name' => 'PEMBERSIHAN RUAS & RAMBU JALAN'],
            ['parent_id' => 1, 'name' => 'PERAWATAN TAMAN RUAS'],
            ['parent_id' => 1, 'name' => 'PEMBUATAN RAMBU'],
            ['parent_id' => 1, 'name' => 'PELAYANAN LALU LINTAS'],
            ['parent_id' => 1, 'name' => 'PELAYANAN MEDICAL'],
            ['parent_id' => 1, 'name' => 'PEMBANGUNAN JALAN TOL'],
            ['parent_id' => 1, 'name' => 'PJU'],
            ['parent_id' => 1, 'name' => 'PEMBONGKARAN'],
            ['parent_id' => 1, 'name' => 'DRAINASE'],
            ['parent_id' => 1, 'name' => 'STEEL PLATE BONDING'],
            ['parent_id' => 1, 'name' => 'FIBER REINFORCED POLYMER'],
            ['parent_id' => 1, 'name' => 'POMPA'],
            ['parent_id' => 1, 'name' => 'EXPANSION JOINT'],
            ['parent_id' => 2, 'name' => 'PERAWATAN AC'],
            ['parent_id' => 2, 'name' => 'RADIO RIG'],
            ['parent_id' => 2, 'name' => 'CLOSED CIRCUIT TELEVISION (CCTV)'],
            ['parent_id' => 2, 'name' => 'PENGECATAN BANGUNAN'],
            ['parent_id' => 2, 'name' => 'ELEKTRIKAL BANGUNAN'],
            ['parent_id' => 2, 'name' => 'INTERIOR BANGUNAN'],
            ['parent_id' => 2, 'name' => 'EXTERIOR BANGUNAN'],
            ['parent_id' => 2, 'name' => 'APAR'],
            ['parent_id' => 2, 'name' => 'POMPA'],
            ['parent_id' => 2, 'name' => 'PEST CONTROL'],
            ['parent_id' => 2, 'name' => 'PABX'],
            ['parent_id' => 3, 'name' => 'PERALATAN TOL'],
            ['parent_id' => 3, 'name' => 'CLOSED CIRCUIT TELEVISION (CCTV)'],
            ['parent_id' => 3, 'name' => 'VARIABLE MESSAGE SIGN'],
            ['parent_id' => 3, 'name' => 'GOOGLE MAP'],
            ['parent_id' => 3, 'name' => 'INTERNET'],
            ['parent_id' => 3, 'name' => 'SOFTWARE'],
            ['parent_id' => 3, 'name' => 'HARDWARE'],
            ['parent_id' => 3, 'name' => 'GPS'],
            ['parent_id' => 4, 'name' => 'KEUANGAN'],
            ['parent_id' => 4, 'name' => 'TRAFFIC'],
            ['parent_id' => 4, 'name' => 'BASIC DESIGN'],
            ['parent_id' => 4, 'name' => 'DETAIL ENGINEERING DESIGN'],
            ['parent_id' => 4, 'name' => 'PERENCANAAN KONSTRUKSI'],
            ['parent_id' => 4, 'name' => 'MANAJEMEN KONSTRUKSI'],
            ['parent_id' => 4, 'name' => 'MANAJEMEN MUTU'],
            ['parent_id' => 4, 'name' => 'AUDIT STRUKTUR'],
            ['parent_id' => 4, 'name' => 'INTERNATIONAL STANDARDIZATION ORGANIZATION (ISO)'],
            ['parent_id' => 4, 'name' => 'OWNER ESTIMATE'],
            ['parent_id' => 4, 'name' => 'PERIJINAN'],
            ['parent_id' => 4, 'name' => 'AMDAL'],
            ['parent_id' => 4, 'name' => 'RIKSA UJI'],
            ['parent_id' => 5, 'name' => 'KANTOR JASA PENILAI PUBLIK'],
            ['parent_id' => 6, 'name' => 'ALAT BERAT'],
            ['parent_id' => 6, 'name' => 'BARANG'],
            ['parent_id' => 6, 'name' => 'ANNUAL REPORT'],
            ['parent_id' => 6, 'name' => 'AIR MINUM'],
            ['parent_id' => 6, 'name' => 'SARANA PERLENGKAPAN KERJA'],
            ['parent_id' => 6, 'name' => 'MESIN FOTOCOPY'],
            ['parent_id' => 6, 'name' => 'AIR BERSIH'],
            ['parent_id' => 6, 'name' => 'ALAT TULIS KANTOR'],
            ['parent_id' => 7, 'name' => 'KESEHATAN'],
            ['parent_id' => 7, 'name' => 'CIVIL ENGINEERING COMPLETED RISK (CECR)'],
            ['parent_id' => 7, 'name' => 'PROPERTY ALL RISK EARTHQUAKE'],
            // Tambahkan data classification lainnya sesuai kebutuhan
        ];

        foreach ($classifications as $classification) {
            Business::create($classification);
        }
    }
}
