<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_bahans', function (Blueprint $table) {
            $table->id('id_bhn');
            $table->string('nama_bahan');
            $table->integer('jumlah_bahan');
            $table->integer('harga_satuan');
            $table->integer('total_harga'); // changed from subtotal to total_harga
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_bahans');
    }
};
