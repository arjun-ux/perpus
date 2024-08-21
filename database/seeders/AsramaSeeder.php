<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_asrama' => 'Az-Zainiyyah',
            ],
            [
                'nama_asrama' => 'Al-Hasyimiyah',
            ],
            [
                'nama_asrama' => 'Mawaddah',
            ],
            [
                'nama_asrama' => 'Fatimatus Zahro',
            ],
            [
                'nama_asrama' => 'Zaid Bin Tsabit',
            ],
            [
                'nama_asrama' => 'Al-Lathifiyah',
            ],
            [
                'nama_asrama' => 'Dhalem Pengasuh',
            ],
            [
                'nama_asrama' => 'DLL',
            ],
        ];
        DB::table('asramas')->insert($data);
    }
}
