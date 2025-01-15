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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->integer('product_id');
            $table->integer('user_id');
            $table->string('nomor_whatsapp');
            $table->string('name_product');
            $table->string('nama');
            $table->string('status')->default('proses');
            $table->string('total_harga');
            $table->integer('jumlah_product');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
