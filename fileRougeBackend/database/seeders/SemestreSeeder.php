<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SemestreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semestres = [
            [
                'libelle' => 'Semestre1',
                'annee_id' => '1',
            ],
            [
                'libelle' => 'Semestre2',
                'annee_id' => '1',
            ]

        ];
        DB::table('semestres')->insert($semestres);
    }
}
