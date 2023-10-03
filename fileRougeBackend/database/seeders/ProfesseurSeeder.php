<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProfesseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professeurs = [
            [
                'nom_complet' => 'Birane Baila Wane',
                'grade' => 'ingenieur',
                'specialite' => 'Dev web/mobile',
                'annee_id' => 1,
            ],
            [
                'nom_complet' => 'Aly Tall Niang',
                'grade' => 'ingenieur',
                'specialite' => 'Dev web/mobile',
                'annee_id' => 1,
            ],
            [
                'nom_complet' => 'Diallo Saikou',
                'grade' => 'ingenieur',
                'specialite' => 'Ref Digital',
                'annee_id' => 1,
            ],
            [
                'nom_complet' => 'Monsieur Mbaye',
                'grade' => 'Docteur',
                'specialite' => 'Dev data',
                'annee_id' => 1,
            ],


        ];
        DB::table('professeurs')->insert($professeurs);
    }
}
