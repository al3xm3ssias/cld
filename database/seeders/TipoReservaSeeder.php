<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_reserva')->insert([
            'tipo_reserva' => 'Disciplinas',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tipo_reserva')->insert([
            'tipo_reserva' => 'Uso Externo',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tipo_reserva')->insert([
            'tipo_reserva' => 'Alunos',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
