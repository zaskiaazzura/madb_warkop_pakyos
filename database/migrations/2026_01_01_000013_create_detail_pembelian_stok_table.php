<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detailpembelianstok', function (Blueprint $table) {
            $table->string('id_detail_pembelian', 12)->primary();
            $table->string('id_pembelian', 12);
            $table->string('id_bahan', 10);
            $table->decimal('jumlah', 10, 2);
            $table->decimal('harga_satuan', 10, 2);
            $table->timestamps();

            $table->foreign('id_pembelian')
                  ->references('id_pembelian')
                  ->on('pembelianstok')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_bahan')
                  ->references('id_bahan')
                  ->on('bahanbaku')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detailpembelianstok');
    }
};
