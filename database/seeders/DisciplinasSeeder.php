<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisciplinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('disciplinas')->insert(['nome' => 'RESERVA EXTERNA']);
        DB::table('disciplinas')->insert(['nome' => 'RESERVA ACADÊMICA']);
        DB::table('disciplinas')->insert(['nome' => 'ANALISE DE ALGOTIMOS']);
        DB::table('disciplinas')->insert(['nome' => 'REDES']);
        DB::table('disciplinas')->insert(['nome' => 'PROJETOS E SISTEMAS DE INFORMAÇÃO']);
        DB::table('disciplinas')->insert(['nome' => 'SISTEMAS DE INFORMAÇÃO 1']);
        DB::table('disciplinas')->insert(['nome' => 'SISTEMAS DE INFORMAÇÃO 2']);
        DB::table('disciplinas')->insert(['nome' => 'ALGORITIMOS', 'turno'=>'N']);
        DB::table('disciplinas')->insert(['nome' => 'ESTRUTURA DE DADOS', 'turno'=>'N']);
        DB::table('disciplinas')->insert(['nome' => 'DESENHO TECNICO', 'turno'=>'T']);

    }
}
