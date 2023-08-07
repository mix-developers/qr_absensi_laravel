<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [

            [
                'name' => 'admin',
                'last_name' => '',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin'
            ],
            [
                'name' => 'mahasiswa',
                'last_name' => '',
                'email' => 'mahasiswa@gmail.com',
                'password' => Hash::make('mahasiswa'),
                'role' => 'mahasiswa'
            ],
        ];

        DB::table('users')->insert($data);
    }
}
