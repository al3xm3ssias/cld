<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaboratoriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('laboratorio')->insert(['nome' => 'LAB 01', 'apelido' => 'LAB 01', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 02', 'apelido' => 'LAB 02', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 03', 'apelido' => 'LAB 03', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 04', 'apelido' => 'LAB 04', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 05', 'apelido' => 'LAB 05', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 06', 'apelido' => 'LAB 06', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 07', 'apelido' => 'LAB 07', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 08', 'apelido' => 'LAB 08', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 09', 'apelido' => 'LAB 09', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 10', 'apelido' => 'LAB 10', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 11', 'apelido' => 'LAB 11', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 12', 'apelido' => 'LAB 12', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 13', 'apelido' => 'LAB 13', 'restrito' => 0]);
        DB::table('laboratorio')->insert(['nome' => 'LAB 14', 'apelido' => 'LAB 14', 'restrito' => 0]);


    }
}
