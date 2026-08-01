<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->string('id_pembayaran', 12)->primary();
            $table->string('id_pesanan', 12)->unique();
            $table->enum('metode_pembayaran', ['tunai', 'QRIS', 'transfer']);
            $table->decimal('jumlah_bayar', 10, 2);
            $table->datetime('tanggal_bayar');
            $table->timestamps();

            $table->foreign('id_pesanan')
                  ->references('id_pesanan')
                  ->on('pesanan')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
