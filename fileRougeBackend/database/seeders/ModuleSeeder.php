<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'libelle' => 'Javascript',
                'annee_id' => '1',
            ],
            [
                'libelle' => 'Html/Css',
                'annee_id' => '1',
            ],
            [
                'libelle' => 'Java',
                'annee_id' => '1',
            ],
            [
                'libelle' => 'Flutter',
                'annee_id' => '1',
            ],
            [
                'libelle' => 'Figma',
                'annee_id' => '1',
            ],
            [
                'libelle' => 'Ionic',
                'annee_id' => '1',
            ],
            [
                'libelle' => 'Php',
                'annee_id' => '1',
            ],
        ];
        DB::table('modules')->insert($modules);
    }
}
