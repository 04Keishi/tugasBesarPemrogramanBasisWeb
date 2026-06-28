<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            // PK auto-increment — user tidak mengisi ID.
            $table->increments('id_product');
            $table->string('deskripsi', 255);

            // Harga satuan produk (Rupiah). Ditampilkan pada master produk dan
            // dipakai sebagai harga acuan saat menambah item Detail PO.
            $table->decimal('harga', 18, 2)->default(0);

            // Kolom vendor: produk yang sama tetapi beda vendor dianggap item
            // terpisah. Produk yang diproduksi sendiri memakai nama
            // "PT Garda Integra Solusindo".
            $table->string('nama_vendor', 150)->default('PT Garda Integra Solusindo');

            // Produk yang sama (deskripsi) + vendor yang sama tidak boleh dobel,
            // tetapi deskripsi sama dengan vendor berbeda diperbolehkan (item baru).
            $table->unique(['deskripsi', 'nama_vendor'], 'product_deskripsi_vendor_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
