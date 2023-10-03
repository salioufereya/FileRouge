<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FiliereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $filieres = [
            [
                'libelle' => 'Dev Web/Mobile',
                'annee_id' => '1',

            ],
            [
                'libelle' => 'Dev Data',
                'annee_id' => '1',

            ],
            [
                'libelle' => 'Ref Digital',
                'annee_id' => '1',

            ],

        ];
        DB::table('filieres')->insert($filieres);
    }
}
