<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(50)->create();
         $this->call([UserSeeder::class]);
         $this->call([TipoSolicitanteSeeder::class]);
         $this->call([TipoReservaSeeder::class]);
         $this->call(DisciplinasSeeder::class);
         $this->call(SolicitanteSeeder::class);
         $this->call(LaboratoriosSeeder::class);
    }
}
