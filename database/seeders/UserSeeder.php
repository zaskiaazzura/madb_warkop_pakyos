<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id_user'     => 'USR001',
                'username'    => 'pakyos_owner',
                'password'    => Hash::make('password123'),
                'role'        => 'pemilik',
                'id_karyawan' => null,
            ],
            [
                'id_user'     => 'USR002',
                'username'    => 'kasir_andi',
                'password'    => Hash::make('password123'),
                'role'        => 'kasir',
                'id_karyawan' => 'KRW001',
            ],
            [
                'id_user'     => 'USR003',
                'username'    => 'kasir_budi',
                'password'    => Hash::make('password123'),
                'role'        => 'kasir',
                'id_karyawan' => 'KRW002',
            ],
            [
                'id_user'     => 'USR004',
                'username'    => 'koki_joko',
                'password'    => Hash::make('password123'),
                'role'        => 'koki',
                'id_karyawan' => 'KRW003',
            ],
            [
                'id_user'     => 'USR005',
                'username'    => 'barista_doni',
                'password'    => Hash::make('password123'),
                'role'        => 'barista',
                'id_karyawan' => 'KRW004',
            ],
            [
                'id_user'     => 'USR006',
                'username'    => 'waiter_eko',
                'password'    => Hash::make('password123'),
                'role'        => 'kasir',
                'id_karyawan' => 'KRW005',
            ],
            [
                'id_user'     => 'USR007',
                'username'    => 'waiter_fani',
                'password'    => Hash::make('password123'),
                'role'        => 'barista',
                'id_karyawan' => 'KRW006',
            ],
        ];

        foreach ($users as $data) {
            User::create($data);
        }
    }
}
