<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detailpesanan', function (Blueprint $table) {
            $table->string('id_detail_pesanan', 12)->primary();
            $table->string('id_pesanan', 12);
            $table->string('id_menu', 10);
            $table->string('id_petugas', 10)->nullable();
            $table->integer('jumlah');
            $table->decimal('subtotal', 10, 2);
            $table->enum('status_item', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
            $table->timestamps();

            $table->foreign('id_pesanan')
                  ->references('id_pesanan')
                  ->on('pesanan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_menu')
                  ->references('id_menu')
                  ->on('menu')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->foreign('id_petugas')
                  ->references('id_karyawan')
                  ->on('karyawan')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detailpesanan');
    }
};
