<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep', function (Blueprint $table) {
            $table->string('id_resep', 12)->primary();
            $table->string('id_menu', 10);
            $table->string('id_bahan', 10);
            $table->decimal('jumlah_dibutuhkan', 10, 2);
            $table->timestamps();

            $table->foreign('id_menu')
                  ->references('id_menu')
                  ->on('menu')
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
        Schema::dropIfExists('resep');
    }
};
