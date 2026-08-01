<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meja;

class MejaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Meja::create([
                'id_meja'     => 'MJ' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nomor_meja'  => $i,
                'status_meja' => 'kosong',
            ]);
        }
    }
}
