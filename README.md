# Sistem Pemesanan dan Pengelolaan Stok — Warkop Pak Yos

Aplikasi basis data dan sistem informasi untuk mendukung pencatatan transaksi 
pemesanan, pengelolaan stok bahan baku, dan pelaporan penjualan harian pada 
Warkop Pak Yos, Lhokseumawe. Dibangun sebagai project akhir mata kuliah 
**Manajemen Administrasi Basis Data (MADB)**.

## 📋 Deskripsi Project

Warkop Pak Yos merupakan usaha warung kopi yang telah berdiri sejak tahun 
1996. Seluruh proses pencatatan transaksi dan pengelolaan stok bahan baku 
masih dilakukan secara manual, sehingga rawan terjadi kesalahan hitung, 
kesalahan nota, dan lemahnya kontrol stok. Project ini merancang dan 
mengimplementasikan basis data relasional (hingga 3NF) beserta aplikasi 
web yang mengintegrasikan alur kerja **kasir, koki, barista, dan pemilik** 
dalam satu sistem.

## 👥 Tim Pengembang — Kelompok 4

| Nama | NIM | Peran |
|---|---|---|
| Zaskia Azzura | 240180140 | Project Manager & Wawancara/Observasi Lapangan |
| Mutia Sitompul | 240180152 | Analisis dan Perancangan Basis Data |
| M. Sutan Naufal Hasibuan | 240180162 | Pengembangan Aplikasi/Sistem |

**Dosen Pengampu:** Zalfie Ardian, S.Kom., M.Eng.
**Program Studi Sistem Informasi, Fakultas Teknik, Universitas Malikussaleh**

## 🛠️ Tech Stack

- **Backend:** Laravel Framework (PHP) + Eloquent ORM
- **Database:** MySQL/MariaDB
- **Tools:** XAMPP, phpMyAdmin, MySQL Workbench

## 🗄️ Struktur Basis Data

Basis data `db_warkop_pakyos` terdiri dari **13 tabel utama**:

`Shift`, `Karyawan`, `Users`, `Meja`, `Menu`, `BahanBaku`, `Supplier`, 
`Resep`, `Pesanan`, `DetailPesanan`, `Pembayaran`, `PembelianStok`, 
`DetailPembelianStok`

Dilengkapi dengan:
- **1 View** — `v_laporan_penjualan_harian` (rekapitulasi laporan penjualan harian)
- **1 Trigger** — `trg_kurangi_stok_otomatis` (pengurangan stok bahan baku otomatis)
- **4 Stored Procedure** — `sp_buat_pesanan_baru`, `sp_tambah_detail_pesanan`, 
  `sp_proses_pembayaran`, `sp_tambah_stok_bahan`

ERD lengkap dan Data Dictionary tersedia pada dokumen laporan (lihat folder `docs/`).

## ⚙️ Fitur Utama

- Pencatatan pesanan (dine-in/takeaway) oleh kasir
- Pembagian otomatis pesanan ke koki (makanan) dan barista (minuman)
- Pelacakan status pesanan real-time (baru → diproses → selesai → terkirim)
- Pencatatan pembayaran (tunai/QRIS/transfer)
- Pengurangan stok bahan baku otomatis berbasis resep menu
- Pencatatan pembelian/restock bahan baku dari supplier
- Dashboard laporan penjualan harian untuk pemilik usaha
- Role-Based Access Control (RBAC) untuk 4 peran: pemilik, kasir, koki, barista

## 🚀 Instalasi

1. Clone repository ini
```bash
   git clone https://github.com/zaskiaazzura/madb_warkop_pakyos.git
   cd madb_warkop_pakyos
```

2. Install dependencies
```bash
   composer install
   npm install
```

3. Salin file environment dan sesuaikan konfigurasi database
```bash
   cp .env.example .env
   php artisan key:generate
```

4. Buat database MySQL/MariaDB
```sql
   CREATE DATABASE db_warkop_pakyos;
```

5. Jalankan migration dan seeder
```bash
   php artisan migrate --seed
```

6. Jalankan server lokal
```bash
   php artisan serve
```

## 📁 Struktur Folder
```bash
├── app/
│ ├── Http/Controllers/ # Controller per role (Pesanan, Dapur, Bar, Pembayaran, Dashboard, Stok)
│ └── Models/ # Model Eloquent untuk 13 tabel
├── database/
│ ├── migrations/ # Migration 13 tabel + View/Trigger/Stored Procedure
│ └── seeders/ # Seeder data master & data dummy transaksi
├── resources/views/ # Blade view per role
├── docs/ # Laporan project, ERD, Data Dictionary
└── README.md
```

## 📜 Lisensi

Project ini dibuat untuk keperluan akademik pada mata kuliah Manajemen dan
Administrasi Basis Data, Program Studi Sistem Informasi, Universitas 
Malikussaleh, Tahun 2026.