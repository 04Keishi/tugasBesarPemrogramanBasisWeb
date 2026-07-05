<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            // PK auto-increment (surrogate). Nomor PO yang ditampilkan ke user
            // (mengandung '/') disimpan di kolom po_no dan di-generate otomatis,
            // sehingga user tidak perlu mengetik ID/nomor apa pun saat menambah.
            $table->increments('id_po');
            $table->string('po_no', 60)->unique();

            $table->unsignedInteger('no_so')->nullable();
            $table->unsignedInteger('id_vendor')->nullable();
            $table->unsignedInteger('id_pegawai')->nullable();
            $table->string('npwp', 40)->nullable();
            $table->integer('qty')->default(0);
            $table->string('payment', 150)->nullable();
            $table->date('tanggal')->nullable();
            $table->text('terbilang')->nullable();
            $table->decimal('grand_total', 18, 2)->default(0);

            /*
             |--------------------------------------------------------------
             | Field INVOICE (digabung ke Purchase Order)
             |--------------------------------------------------------------
             | Invoice tidak lagi menjadi tabel/entitas terpisah. Data invoice
             | menempel langsung pada PO. no_invoice di-generate otomatis.
            */
            $table->string('no_invoice', 60)->nullable()->unique();
            $table->date('tanggal_invoice')->nullable();
            $table->text('alamat_invoice')->nullable();
            $table->string('tax_code', 40)->nullable();
            $table->decimal('total_invoice', 18, 2)->default(0);
            $table->string('no_telp', 30)->nullable();
            $table->string('terms', 100)->nullable();
            $table->string('bast', 60)->nullable();
            $table->string('spk_no', 60)->nullable();
            $table->string('rekening', 120)->nullable();

            // PO mengambil data dari project, vendor, dan pegawai. Karena itu
            // project / vendor / pegawai yang masih terhubung dengan PO TIDAK BISA
            // dihapus (restrictOnDelete). Hapus dulu PO terkait sebelum menghapus
            // data master tersebut.
            $table->foreign('no_so')
                  ->references('no_so')->on('project')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('id_vendor')
                  ->references('id_vendor')->on('vendor')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('id_pegawai')
                  ->references('id_pegawai')->on('pegawai')
                  ->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order');
    }
};
