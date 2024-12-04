<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Hash;
use DB;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cId = DB::table('companies')->insertGetId([
            'name' => 'PT. Pakar Teknologi Indonesia',
            'email' => 'pakartech@gmail.com',
            'phone_number' => '08'.rand(0,9).rand(1,9).rand(2,9).rand(3,9).rand(4,9).rand(5,9).rand(6,9).rand(7,9).rand(8,9),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $cId2 = DB::table('companies')->insertGetId([
            'name' => 'PT. PHP Indonesia',
            'email' => 'phpi@gmail.com',
            'phone_number' => '08'.rand(0,9).rand(1,9).rand(2,9).rand(3,9).rand(4,9).rand(5,9).rand(6,9).rand(7,9).rand(8,9),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            [
                'role_id' => 2,
                'company_id' => $cId,
                'name' => 'Sholikin',
                'email' => 'okin@gmail.com',
                'phone_number' => '08'.rand(0,9).rand(1,9).rand(2,9).rand(3,9).rand(4,9).rand(5,9).rand(6,9).rand(7,9).rand(8,9),
                'address' => 'Jl. Pasuruan 4, Kota Pasuruan, Jawa Timur',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'role_id' => 3,
                'company_id' => $cId,
                'name' => 'Adi',
                'email' => 'adi@gmail.com',
                'phone_number' => '08'.rand(0,9).rand(1,9).rand(2,9).rand(3,9).rand(4,9).rand(5,9).rand(6,9).rand(7,9).rand(8,9),
                'address' => 'Jl. Kapi Minda 5, Kab. Malang, Jawa Timur',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'role_id' => 3,
                'company_id' => $cId,
                'name' => 'Edi',
                'email' => 'edi@gmail.com',
                'phone_number' => '08'.rand(0,9).rand(1,9).rand(2,9).rand(3,9).rand(4,9).rand(5,9).rand(6,9).rand(7,9).rand(8,9),
                'address' => 'Jl. Kapi Minda 6, Kab. Malang, Jawa Timur',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'role_id' => 2,
                'company_id' => $cId2,
                'name' => 'Aqil',
                'email' => 'aqil@gmail.com',
                'phone_number' => '08'.rand(0,9).rand(1,9).rand(2,9).rand(3,9).rand(4,9).rand(5,9).rand(6,9).rand(7,9).rand(8,9),
                'address' => 'Jl. Pasuruan 8, Kota Pasuruan, Jawa Timur',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'role_id' => 3,
                'company_id' => $cId2,
                'name' => 'Yusyac',
                'email' => 'yack@gmail.com',
                'phone_number' => '08'.rand(0,9).rand(1,9).rand(2,9).rand(3,9).rand(4,9).rand(5,9).rand(6,9).rand(7,9).rand(8,9),
                'address' => 'Jl. Kapi Woro 7, Kab. Malang, Jawa Timur',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'role_id' => 3,
                'company_id' => $cId2,
                'name' => 'Irul',
                'email' => 'irul@gmail.com',
                'phone_number' => '08'.rand(0,9).rand(1,9).rand(2,9).rand(3,9).rand(4,9).rand(5,9).rand(6,9).rand(7,9).rand(8,9),
                'address' => 'Jl. Kapi Subali 10, Kab. Malang, Jawa Timur',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
