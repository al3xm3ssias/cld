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
        DB::table('users')->insert([
            'nome' => 'Administrador',
            'email' => 'admin@admin.com',
            'CPF' => '00000000000',
            'password' => bcrypt('admin@admin.com'),
            'status' => 'actived',
            'gender' => 'male',
            'profile' => 'admin'


        ]);
    }
}
