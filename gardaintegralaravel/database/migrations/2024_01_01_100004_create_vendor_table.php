<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor', function (Blueprint $table) {
            // PK auto-increment.
            $table->increments('id_vendor');
            $table->string('pic', 100)->nullable();
            $table->string('nama_supplier', 150);
            $table->text('alamat')->nullable();
            $table->string('nohp_pic', 30)->nullable();
            $table->string('no_telp', 30)->nullable();
            $table->string('fax', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor');
    }
};
