<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id_user', 10)->primary();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->enum('role', ['pemilik', 'kasir', 'koki', 'barista']);
            $table->string('id_karyawan', 10)->nullable();
            $table->timestamps();

            $table->foreign('id_karyawan')
                  ->references('id_karyawan')
                  ->on('karyawan')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
