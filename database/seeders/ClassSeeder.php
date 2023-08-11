<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
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
                'name' => 'A',
            ],
            [
                'name' => 'B',
            ],
            [
                'name' => 'C',
            ],
        ];

        DB::table('classes')->insert($data);
    }
}
