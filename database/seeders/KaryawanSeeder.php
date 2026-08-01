<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $karyawan = [
            [
                'id_karyawan'   => 'KRW001',
                'nama_karyawan' => 'Andi Saputra',
                'peran'         => 'kasir',
                'no_telepon'    => '081234567801',
                'id_shift'      => null,
            ],
            [
                'id_karyawan'   => 'KRW002',
                'nama_karyawan' => 'Budi Santoso',
                'peran'         => 'kasir',
                'no_telepon'    => '081234567802',
                'id_shift'      => null,
            ],
            [
                'id_karyawan'   => 'KRW003',
                'nama_karyawan' => 'Chef Joko Suprianto',
                'peran'         => 'koki',
                'no_telepon'    => '081234567803',
                'id_shift'      => null,
            ],
            [
                'id_karyawan'   => 'KRW004',
                'nama_karyawan' => 'Doni Barista',
                'peran'         => 'barista',
                'no_telepon'    => '081234567804',
                'id_shift'      => null,
            ],
            [
                'id_karyawan'   => 'KRW005',
                'nama_karyawan' => 'Eko Prasetyo',
                'peran'         => 'waiters',
                'no_telepon'    => '081234567805',
                'id_shift'      => null,
            ],
            [
                'id_karyawan'   => 'KRW006',
                'nama_karyawan' => 'Fani Rahmawati',
                'peran'         => 'waiters',
                'no_telepon'    => '081234567806',
                'id_shift'      => null,
            ],
        ];

        foreach ($karyawan as $data) {
            Karyawan::create($data);
        }
    }
}
