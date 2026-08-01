<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembelianstok', function (Blueprint $table) {
            $table->string('id_pembelian', 12)->primary();
            $table->string('id_supplier', 10);
            $table->date('tanggal_pembelian');
            $table->decimal('total_pembelian', 12, 2);
            $table->timestamps();

            $table->foreign('id_supplier')
                  ->references('id_supplier')
                  ->on('supplier')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembelianstok');
    }
};
