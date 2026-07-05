<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer', function (Blueprint $table) {
            // PK auto-increment — tidak perlu input ID manual.
            $table->increments('id_customer');
            $table->string('nama_rek', 100);
            $table->string('no_rek', 50)->nullable();
            $table->text('alamat')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
