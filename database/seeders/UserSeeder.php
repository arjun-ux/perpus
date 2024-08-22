<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name'=>'Arjun',
                'username'=>'dev',
                'email'=>'arjun@dev.com',
                'password'=>'$2y$12$ijfxX/vsmC7yIF8sQR8Mautd.Y9R81Rp5DjQzVNLWWqdZ4WOTD3Bi',
                'role' => 'dev',
            ],
            [
                'name'=>'Admin',
                'username'=>'admin',
                'email'=>'admin@gmail.com',
                'password'=>Hash::make('asdasd'),
                'role' => 'admin',
            ],
            [
                'name'=>'Santri',
                'username'=>'santri',
                'email'=>'santri@gmail.com',
                'password'=>Hash::make('asdasd'),
                'role' => 'santri',
            ],
            [
                'name'=>'Mitra',
                'username'=>'mitra',
                'email'=>'mitra@gmail.com',
                'password'=>Hash::make('asdasd'),
                'role' => 'mitra',
            ]

        ];
        DB::table('users')->insert($data);
    }
}
