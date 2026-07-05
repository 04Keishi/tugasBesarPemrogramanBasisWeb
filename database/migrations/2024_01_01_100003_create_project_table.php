<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project', function (Blueprint $table) {
            // PK auto-increment.
            $table->increments('no_so');
            $table->unsignedInteger('id_customer')->nullable();
            $table->string('nama_project', 200);

            // Project mengambil data dari customer, sehingga customer yang masih
            // terhubung dengan project TIDAK BISA dihapus (restrictOnDelete).
            // Hapus dulu project terkait sebelum menghapus customer.
            $table->foreign('id_customer')
                  ->references('id_customer')->on('customer')
                  ->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
