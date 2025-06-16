<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CompanyProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('headers')->insert([
            'tittle' => 'Butik Konveksi Berkualitas  dan Terpercaya.',
            'image' => 'images/headers/1750046338_5RyeeLUd3J.png',
            'description' => 'Melayani pembuatan pakaian custom, 
seragam, hingga busana fashion dengan sentuhan profesional dan hasil terbaik.',
        ]);
        DB::table('abouts')->insert([
            'tittle' => 'LablesMM',
            'image' => 'images/abouts/1750045021_vB1ZysVpsQ.jpg',
            'deskripsi' => 'Labels MM adalah aplikasi manajemen bisnis yang dirancang untuk menyederhanakan segala hal dari pencatatan transaksi, pengelolaan barang, hingga pelacakan stok dan laporan penjualan. Kami hadir untuk membantu UMKM, toko retail, dan pelaku usaha lainnya dalam menjalankan operasional harian secara lebih rapi, cepat, dan efisien.',
        ]);
    }
}
