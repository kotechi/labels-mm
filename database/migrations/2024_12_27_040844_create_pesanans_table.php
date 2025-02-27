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
            $table->string('nama_pemesan');
            $table->integer('product_id');
            $table->string('no_telp_pemesan');
            $table->string('nama_produk');
            $table->integer('jumlah_produk');
            $table->string('total_harga');
            $table->string('payment_method');
            $table->integer('created_by');
            $table->string('status_pesanan');
            $table->timestamp('order_date')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->decimal('lebar_muka', 8, 2)->nullable();
            $table->decimal('lebar_pundak', 8, 2)->nullable();
            $table->decimal('lebar_punggung', 8, 2)->nullable();
            $table->decimal('panjang_lengan', 8, 2)->nullable();
            $table->decimal('panjang_punggung', 8, 2)->nullable();
            $table->decimal('panjang_baju', 8, 2)->nullable();
            $table->decimal('lingkar_badan', 8, 2)->nullable();
            $table->decimal('lingkar_pinggang', 8, 2)->nullable();
            $table->decimal('lingkar_panggul', 8, 2)->nullable();
            $table->decimal('lingkar_kerung_lengan', 8, 2)->nullable();
            $table->decimal('lingkar_pergelangan_lengan', 8, 2)->nullable();
            
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
