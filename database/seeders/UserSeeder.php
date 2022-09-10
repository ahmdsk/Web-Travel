<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbluser')->insert([
            'username'  => 'admin',
            'nama'      => 'Administrator',
            'email'     => 'admin@tes.com',
            'password'  => bcrypt('12345678'),
            'role' 	    => 'Admin',
            'no_telp'   => '08123456789',
            'tgl_lahir' => date_create('01-01-1990'),
            'umur'      => 27,
            'nik'       => '1871020304050',
            'agama'     => 'Islam',
            'alamat'    => 'Bandar Lampung',
            'status_aktif' => 1,
        ]);
    }
}
