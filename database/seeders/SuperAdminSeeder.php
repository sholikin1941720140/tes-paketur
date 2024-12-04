<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Hash;
use DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role_id' => 1,
                'name' => 'Admin Paketur',
                'email' => 'paketur@gmail.com',
                'phone_number' => '08'.rand(0,9).rand(1,9).rand(2,9).rand(3,9).rand(4,9).rand(5,9).rand(6,9).rand(7,9).rand(8,9),
                'address' => 'Jl. Magelang No.188, Kota Yogyakarta, Daerah Istimewa Yogyakarta',
                'password' => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
