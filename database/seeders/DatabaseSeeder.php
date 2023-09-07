<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Partner;
use App\Models\Business;
use App\Models\Procurement;
use App\Models\BusinessPartner;
use Illuminate\Database\Seeder;
use Database\Seeders\BusinessPartnerSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ExampleDivisionSeeder::class,
            ExampleOfficialSeeder::class,
            ExampleCoreBusinessSeeder::class,
            ExampleClassificationSeeder::class,
        ]);

        Partner::factory(20)->create();
        Procurement::factory(5)->create();

        // BusinessPartner::factory(50)->create();
        $this->call(BusinessPartnerSeeder::class);

    }
}
