<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $member1 = User::create([
            'name' => 'DAVAN INDRA KUSUMA',
            'username' => '2201950696',
            'password' => 'popo',
            'role' => 'Member',
        ]);

        Member::create([
            'user_id' => '2',
            'class_id' => '3',
            'username' => $member1->username,
            'status' => '2'
        ]);
        $member2 = User::create([
            'name' => 'FAUZAN ABDILLAH',
            'username' => '2201950701',
            'password' => 'popo',
            'role' => 'Member',
        ]);

        Member::create([
            'user_id' => '3',
            'class_id' => '4',
            'username' => $member2->username,
            'status' => '2'
        ]);
        $member3 = User::create([
            'name' => 'RACHEL RASENDRIYA FARENZA',
            'username' => '2201950712',
            'password' => 'popo',
            'role' => 'Member',
        ]);

        Member::create([
            'user_id' => '4',
            'class_id' => '5',
            'username' => $member3->username,
            'status' => '2'
        ]);
    }
}
