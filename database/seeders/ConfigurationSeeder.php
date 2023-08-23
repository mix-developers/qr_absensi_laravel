<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeder extends Seeder
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
                'jurusan' => 'SIstem Informasi',
                'kajur' => 'Ir. Jarot Budiasto ,S.T.,M.T',
                'nip' => '1204038101'
            ]
        ];
        DB::table('configurations')->insert($data);
    }
}
