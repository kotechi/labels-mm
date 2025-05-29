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
            'image' => 'https://example.com/image.jpg',
            'description' => 'Melayani  pembuatan  pakaian    custom, 
seragam, hingga busana fashion dengan 
sentuhan   profesional  dan hasil terbaik.',
        ]);
        DB::table('abouts')->insert([
            'tittle' => 'LablesMM',
            'image' => 'https://example.com/image.jpg',
            'deskripsi' => 'Labels – MM adalah butik  konveksi lokal yang  berdedikasi 
menghadirkan    pakaian     berkualitas       tinggi     dengan   
sentuhan personal. Kami percaya bahwa    setiap  helai kain
memiliki cerita, dan tugas kami adalah mewujudkan cerita 
itu menjadi kenyataan dalam bentuk busana yang  anggun, 
rapi, dan nyaman dikenakan.
Dengan tim profesional dan pengalaman bertahun-tahun,
kami melayani  beragam  kebutuhan     mulai dari  pakaian 
formal, seragam, hingga desain custom sesuai permintaan.',
        ]);
    }
}
