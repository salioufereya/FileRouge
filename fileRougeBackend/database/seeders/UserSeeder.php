<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nom' => 'diallo',
                'prenom' => 'mamadou',
                'email' => 'mamadou@gmail.com',
                'password' => Hash::make(12345),
                'role' => 'RP'
            ],

        ];
        DB::table('users')->insert($users);
    }
}
