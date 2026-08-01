<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BahanBaku;

class BahanBakuSeeder extends Seeder
{
    public function run(): void
    {
        $bahan = [
            [
                'id_bahan'   => 'BHN001',
                'nama_bahan' => 'Biji Kopi Ulee Kareng',
                'kategori'   => 'tahan lama',
                'stok'       => 50.00,
                'satuan'     => 'kg',
            ],
            [
                'id_bahan'   => 'BHN002',
                'nama_bahan' => 'Susu Kental Manis',
                'kategori'   => 'tahan lama',
                'stok'       => 30.00,
                'satuan'     => 'kaleng',
            ],
            [
                'id_bahan'   => 'BHN003',
                'nama_bahan' => 'Susu Evaporasi',
                'kategori'   => 'tahan lama',
                'stok'       => 20.00,
                'satuan'     => 'kaleng',
            ],
            [
                'id_bahan'   => 'BHN004',
                'nama_bahan' => 'Gula Pasir',
                'kategori'   => 'tahan lama',
                'stok'       => 40.00,
                'satuan'     => 'kg',
            ],
            [
                'id_bahan'   => 'BHN005',
                'nama_bahan' => 'Teh Hitam Premium',
                'kategori'   => 'tahan lama',
                'stok'       => 15.00,
                'satuan'     => 'kg',
            ],
            [
                'id_bahan'   => 'BHN006',
                'nama_bahan' => 'Telur Ayam Kampong',
                'kategori'   => 'segar',
                'stok'       => 100.00,
                'satuan'     => 'butir',
            ],
            [
                'id_bahan'   => 'BHN007',
                'nama_bahan' => 'Mie Pangsit Basah',
                'kategori'   => 'segar',
                'stok'       => 25.00,
                'satuan'     => 'kg',
            ],
            [
                'id_bahan'   => 'BHN008',
                'nama_bahan' => 'Daging Ayam Fillet',
                'kategori'   => 'segar',
                'stok'       => 15.00,
                'satuan'     => 'kg',
            ],
            [
                'id_bahan'   => 'BHN009',
                'nama_bahan' => 'Bakso Sapi',
                'kategori'   => 'segar',
                'stok'       => 20.00,
                'satuan'     => 'kg',
            ],
            [
                'id_bahan'   => 'BHN010',
                'nama_bahan' => 'Alpukat Segar',
                'kategori'   => 'segar',
                'stok'       => 10.00,
                'satuan'     => 'kg',
            ],
            [
                'id_bahan'   => 'BHN011',
                'nama_bahan' => 'Jeruk Peras',
                'kategori'   => 'segar',
                'stok'       => 15.00,
                'satuan'     => 'kg',
            ],
            [
                'id_bahan'   => 'BHN012',
                'nama_bahan' => 'Sirup Marquisa',
                'kategori'   => 'tahan lama',
                'stok'       => 12.00,
                'satuan'     => 'botol',
            ],
            [
                'id_bahan'   => 'BHN013',
                'nama_bahan' => 'Bubuk Cappucino',
                'kategori'   => 'tahan lama',
                'stok'       => 10.00,
                'satuan'     => 'kg',
            ],
            [
                'id_bahan'   => 'BHN014',
                'nama_bahan' => 'Roti Tawar',
                'kategori'   => 'segar',
                'stok'       => 30.00,
                'satuan'     => 'bungkus',
            ],
            [
                'id_bahan'   => 'BHN015',
                'nama_bahan' => 'Myo/Minyak Goreng',
                'kategori'   => 'tahan lama',
                'stok'       => 50.00,
                'satuan'     => 'liter',
            ],
        ];

        foreach ($bahan as $data) {
            BahanBaku::create($data);
        }
    }
}
