<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            DB::unprepared("
                DROP VIEW IF EXISTS v_laporan_penjualan_harian;
                CREATE VIEW v_laporan_penjualan_harian AS
                SELECT 
                    DATE(tanggal_bayar) AS tanggal,
                    COUNT(DISTINCT id_pesanan) AS total_transaksi,
                    SUM(jumlah_bayar) AS total_pendapatan
                FROM pembayaran
                GROUP BY DATE(tanggal_bayar)
                ORDER BY tanggal DESC;
            ");

            DB::unprepared("
                DROP TRIGGER IF EXISTS trg_kurangi_stok_otomatis;
                CREATE TRIGGER trg_kurangi_stok_otomatis
                AFTER INSERT ON detailpesanan
                FOR EACH ROW
                BEGIN
                    UPDATE bahanbaku
                    SET stok = stok - (
                        SELECT r.jumlah_dibutuhkan * NEW.jumlah
                        FROM resep r
                        WHERE r.id_bahan = bahanbaku.id_bahan AND r.id_menu = NEW.id_menu
                    )
                    WHERE id_bahan IN (
                        SELECT id_bahan FROM resep WHERE id_menu = NEW.id_menu
                    );
                END;
            ");
        } else {
            DB::unprepared("
                CREATE OR REPLACE VIEW v_laporan_penjualan_harian AS
                SELECT 
                    DATE(tanggal_bayar) AS tanggal,
                    COUNT(DISTINCT id_pesanan) AS total_transaksi,
                    SUM(jumlah_bayar) AS total_pendapatan
                FROM pembayaran
                GROUP BY DATE(tanggal_bayar)
                ORDER BY tanggal DESC;
            ");

            DB::unprepared("
                DROP TRIGGER IF EXISTS trg_kurangi_stok_otomatis;
                CREATE TRIGGER trg_kurangi_stok_otomatis
                AFTER INSERT ON detailpesanan
                FOR EACH ROW
                BEGIN
                    UPDATE bahanbaku b
                    INNER JOIN resep r ON b.id_bahan = r.id_bahan
                    SET b.stok = b.stok - (r.jumlah_dibutuhkan * NEW.jumlah)
                    WHERE r.id_menu = NEW.id_menu;
                END;
            ");

            DB::unprepared("
                DROP PROCEDURE IF EXISTS sp_buat_pesanan_baru;
                CREATE PROCEDURE sp_buat_pesanan_baru(
                    IN p_id_pesanan VARCHAR(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_id_meja VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_id_kasir VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_jenis_pesanan VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
                )
                BEGIN
                    INSERT INTO pesanan (id_pesanan, id_meja, id_kasir, jenis_pesanan, tanggal_waktu, status_pesanan, created_at, updated_at)
                    VALUES (p_id_pesanan, p_id_meja, p_id_kasir, p_jenis_pesanan, NOW(), 'baru', NOW(), NOW());

                    IF p_jenis_pesanan = 'dine-in' AND p_id_meja IS NOT NULL THEN
                        UPDATE meja SET status_meja = 'terisi' WHERE id_meja = p_id_meja;
                    END IF;
                END;
            ");

            DB::unprepared("
                DROP PROCEDURE IF EXISTS sp_tambah_detail_pesanan;
                CREATE PROCEDURE sp_tambah_detail_pesanan(
                    IN p_id_detail VARCHAR(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_id_pesanan VARCHAR(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_id_menu VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_id_petugas VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_jumlah INT
                )
                BEGIN
                    DECLARE v_harga DECIMAL(10,2);
                    DECLARE v_subtotal DECIMAL(10,2);

                    SELECT harga INTO v_harga FROM menu WHERE id_menu = p_id_menu;
                    SET v_subtotal = v_harga * p_jumlah;

                    INSERT INTO detailpesanan (id_detail_pesanan, id_pesanan, id_menu, id_petugas, jumlah, subtotal, status_item, created_at, updated_at)
                    VALUES (p_id_detail, p_id_pesanan, p_id_menu, p_id_petugas, p_jumlah, v_subtotal, 'menunggu', NOW(), NOW());
                END;
            ");

            DB::unprepared("
                DROP PROCEDURE IF EXISTS sp_proses_pembayaran;
                CREATE PROCEDURE sp_proses_pembayaran(
                    IN p_id_pembayaran VARCHAR(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_id_pesanan VARCHAR(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_metode VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_jumlah_bayar DECIMAL(10,2)
                )
                BEGIN
                    DECLARE v_id_meja VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

                    INSERT INTO pembayaran (id_pembayaran, id_pesanan, metode_pembayaran, jumlah_bayar, tanggal_bayar, created_at, updated_at)
                    VALUES (p_id_pembayaran, p_id_pesanan, p_metode, p_jumlah_bayar, NOW(), NOW(), NOW());

                    UPDATE pesanan SET status_pesanan = 'selesai' WHERE id_pesanan = p_id_pesanan;

                    SELECT id_meja INTO v_id_meja FROM pesanan WHERE id_pesanan = p_id_pesanan;

                    IF v_id_meja IS NOT NULL THEN
                        UPDATE meja SET status_meja = 'kosong' WHERE id_meja = v_id_meja;
                    END IF;
                END;
            ");

            DB::unprepared("
                DROP PROCEDURE IF EXISTS sp_tambah_stok_bahan;
                CREATE PROCEDURE sp_tambah_stok_bahan(
                    IN p_id_bahan VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                    IN p_jumlah_tambah DECIMAL(10,2)
                )
                BEGIN
                    UPDATE bahanbaku SET stok = stok + p_jumlah_tambah WHERE id_bahan = p_id_bahan;
                END;
            ");
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::unprepared("DROP PROCEDURE IF EXISTS sp_tambah_stok_bahan;");
            DB::unprepared("DROP PROCEDURE IF EXISTS sp_proses_pembayaran;");
            DB::unprepared("DROP PROCEDURE IF EXISTS sp_tambah_detail_pesanan;");
            DB::unprepared("DROP PROCEDURE IF EXISTS sp_buat_pesanan_baru;");
        }
        DB::unprepared("DROP TRIGGER IF EXISTS trg_kurangi_stok_otomatis;");
        DB::unprepared("DROP VIEW IF EXISTS v_laporan_penjualan_harian;");
    }
};
