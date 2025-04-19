<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->integer('id_referens');
            $table->integer('pelaku_transaksi');
            $table->string('keterangan');
            $table->string('kategori');
            $table->decimal('nominal', 20, 2);
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksis');
    }
};
