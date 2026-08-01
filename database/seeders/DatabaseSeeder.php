<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KaryawanSeeder::class,
            UserSeeder::class,
            MejaSeeder::class,
            MenuSeeder::class,
            BahanBakuSeeder::class,
            SupplierSeeder::class,
        ]);
    }
}
