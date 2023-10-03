<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'libelle' => 'Dev web1A',
                'niveau_id' => 1,
                'filiere_id' => 1,
                'annee_id' => 1,
                'effectif' => 30
            ],
            [
                'libelle' => 'Dev web1B',
                'niveau_id' => 1,
                'filiere_id' => 1,
                'annee_id' => 1,
                'effectif' => 20
            ],
            [
                'libelle' => 'Dev data1A',
                'niveau_id' => 1,
                'filiere_id' => 2,
                'annee_id' => 1,
                'effectif' => 20
            ],
            [
                'libelle' => 'Dev data1B',
                'niveau_id' => 1,
                'filiere_id' => 2,
                'annee_id' => 1,
                'effectif' => 15
            ],
            [
                'libelle' => 'Ref dig1A',
                'niveau_id' => 1,
                'filiere_id' => 3,
                'annee_id' => 1,
                'effectif' => 30
            ],
            [
                'libelle' => 'Dev dig1B',
                'niveau_id' => 1,
                'filiere_id' => 3,
                'annee_id' => 1,
                'effectif' => 25
            ],
        ];
        DB::table('classes')->insert($classes);
    }
}
