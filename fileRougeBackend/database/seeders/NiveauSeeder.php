<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = [
            [
                'libelle' => 'Licence1',
                'annee_id' => '1',
            ],
            [
                'libelle' => 'Licence2',
                'annee_id' => '1',
            ],
            [
                'libelle' => 'Licence3',
                'annee_id' => '1',
            ]

        ];
        DB::table('niveaux')->insert($niveaux);
    }
}
