<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            // Primary key auto-increment — ID di-generate otomatis oleh database,
            // user tidak perlu mengisi ID saat menambah data.
            $table->increments('id_pegawai');
            $table->string('nama_pegawai', 100);
            $table->string('jabatan', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
