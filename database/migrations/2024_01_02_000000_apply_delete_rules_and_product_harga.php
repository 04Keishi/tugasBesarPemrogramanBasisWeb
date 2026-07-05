<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migrasi tambahan untuk database yang SUDAH terisi.
|--------------------------------------------------------------------------
| Jalankan migrasi ini bila Anda tidak ingin melakukan `migrate:fresh`.
| Isinya menerapkan tiga perubahan terbaru pada skema yang sudah ada:
|
|   1. Menambah kolom `harga` pada tabel `product` (jika belum ada).
|   2. Mengubah relasi Customer -> Project menjadi RESTRICT saat hapus,
|      sehingga customer yang masih dipakai project tidak bisa dihapus.
|   3. Mengubah relasi Project/Vendor/Pegawai -> Purchase Order menjadi
|      RESTRICT saat hapus, sehingga data master yang masih dipakai PO
|      tidak bisa dihapus.
|
| Catatan: nama foreign key di bawah memakai konvensi default Laravel
| ({tabel}_{kolom}_foreign). Bila skema lama memakai nama berbeda,
| sesuaikan nama constraint pada drop di bawah.
*/
return new class extends Migration
{
    public function up(): void
    {
        // 1) Tambah kolom harga pada product (jika belum ada).
        if (! Schema::hasColumn('product', 'harga')) {
            Schema::table('product', function (Blueprint $table) {
                $table->decimal('harga', 18, 2)->default(0)->after('deskripsi');
            });
        }

        // 2) Project.id_customer -> RESTRICT on delete.
        Schema::table('project', function (Blueprint $table) {
            $table->dropForeign('project_id_customer_foreign');
            $table->foreign('id_customer')
                  ->references('id_customer')->on('customer')
                  ->cascadeOnUpdate()->restrictOnDelete();
        });

        // 3) Purchase Order (no_so / id_vendor / id_pegawai) -> RESTRICT on delete.
        Schema::table('purchase_order', function (Blueprint $table) {
            $table->dropForeign('purchase_order_no_so_foreign');
            $table->dropForeign('purchase_order_id_vendor_foreign');
            $table->dropForeign('purchase_order_id_pegawai_foreign');

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
        // Kembalikan relasi ke perilaku lama (nullOnDelete) dan hapus kolom harga.
        Schema::table('purchase_order', function (Blueprint $table) {
            $table->dropForeign('purchase_order_no_so_foreign');
            $table->dropForeign('purchase_order_id_vendor_foreign');
            $table->dropForeign('purchase_order_id_pegawai_foreign');

            $table->foreign('no_so')
                  ->references('no_so')->on('project')
                  ->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('id_vendor')
                  ->references('id_vendor')->on('vendor')
                  ->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('id_pegawai')
                  ->references('id_pegawai')->on('pegawai')
                  ->cascadeOnUpdate()->nullOnDelete();
        });

        Schema::table('project', function (Blueprint $table) {
            $table->dropForeign('project_id_customer_foreign');
            $table->foreign('id_customer')
                  ->references('id_customer')->on('customer')
                  ->cascadeOnUpdate()->nullOnDelete();
        });

        if (Schema::hasColumn('product', 'harga')) {
            Schema::table('product', function (Blueprint $table) {
                $table->dropColumn('harga');
            });
        }
    }
};
