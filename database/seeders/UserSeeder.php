<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'nama_lengkap' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'usertype' => 'admin',
            'no_telp' => '08123456789',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}