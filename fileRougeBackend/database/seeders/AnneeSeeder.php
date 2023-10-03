<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $annee = [
            [
                'libelle' => '20223',
            ],
            [
                'libelle' => '2024',
            ],
            [
                'libelle' => '2025',
            ],

        ];
        DB::table('annees')->insert($annee);
    }
}
