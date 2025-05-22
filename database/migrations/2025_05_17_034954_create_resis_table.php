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
        Schema::create('resis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id')->unique();
            $table->string('nomor_resi');
            $table->timestamp('tanggal');
            $table->decimal('total_pembayaran', 15, 2);
            $table->decimal('jumlah_pembayaran', 15, 2)->nullable();
            $table->decimal('kembalian', 15, 2)->default(0);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resis');
    }
};
