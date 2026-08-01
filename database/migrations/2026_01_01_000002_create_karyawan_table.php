<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->string('id_karyawan', 10)->primary();
            $table->string('nama_karyawan', 100);
            $table->enum('peran', ['kasir', 'koki', 'barista', 'waiters']);
            $table->string('no_telepon', 15);
            $table->string('id_shift', 10)->nullable();
            $table->timestamps();

            $table->foreign('id_shift')
                  ->references('id_shift')
                  ->on('shift')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
