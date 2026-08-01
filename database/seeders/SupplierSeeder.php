<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $supplier = [
            [
                'id_supplier'   => 'SUP001',
                'nama_supplier' => 'PT Kopi Nusantara Aceh',
                'kontak'        => '081234567890',
                'alamat'        => 'Jl. Gajah Mada No. 12, Banda Aceh',
            ],
            [
                'id_supplier'   => 'SUP002',
                'nama_supplier' => 'CV Sembako Jaya Utama',
                'kontak'        => '085298765432',
                'alamat'        => 'Jl. T. Nyak Arief No. 45, Banda Aceh',
            ],
            [
                'id_supplier'   => 'SUP003',
                'nama_supplier' => 'Toko Bahan Segar Pak Syakur',
                'kontak'        => '081377889900',
                'alamat'        => 'Pasar Peunayong No. 8, Banda Aceh',
            ],
        ];

        foreach ($supplier as $data) {
            Supplier::create($data);
        }
    }
}
