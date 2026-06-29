<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_po', function (Blueprint $table) {
            $table->increments('id_detail');
            $table->unsignedInteger('id_po')->nullable();
            $table->unsignedInteger('id_product')->nullable();
            $table->integer('qty')->default(1);
            $table->decimal('diskon', 18, 2)->default(0);
            $table->decimal('subtotal_unit', 18, 2)->default(0);
            $table->decimal('subtotal_final', 18, 2)->default(0);
            $table->decimal('ppn_11', 18, 2)->default(0);

            /*
             | CONSTRAINT parent–child:
             | - Produk yang sudah dipakai di detail PO TIDAK BISA dihapus dari
             |   master product (restrictOnDelete). Baris detail PO tidak ikut
             |   terhapus / berubah ketika ada percobaan hapus produk.
             | - PO yang masih memiliki item detail juga tidak bisa dihapus
             |   (restrictOnDelete) sebelum item-itemnya dihapus lebih dulu.
            */
            $table->foreign('id_po')
                  ->references('id_po')->on('purchase_order')
                  ->cascadeOnUpdate()->restrictOnDelete();
            $table->foreign('id_product')
                  ->references('id_product')->on('product')
                  ->cascadeOnUpdate()->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_po');
    }
};
