<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->string('id_pesanan', 12)->primary();
            $table->string('id_meja', 10)->nullable();
            $table->string('id_kasir', 10);
            $table->enum('jenis_pesanan', ['dine-in', 'takeaway']);
            $table->datetime('tanggal_waktu');
            $table->enum('status_pesanan', ['baru', 'diproses', 'selesai', 'terkirim'])->default('baru');
            $table->timestamps();

            $table->foreign('id_meja')
                  ->references('id_meja')
                  ->on('meja')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('id_kasir')
                  ->references('id_karyawan')
                  ->on('karyawan')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
