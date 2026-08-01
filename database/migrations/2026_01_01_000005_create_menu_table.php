<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->string('id_menu', 10)->primary();
            $table->string('nama_menu', 100);
            $table->enum('kategori', ['makanan', 'minuman', 'cemilan']);
            $table->decimal('harga', 10, 2);
            $table->enum('status_ketersediaan', ['tersedia', 'habis'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
