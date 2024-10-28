<?php

namespace Database\Seeders;

use App\Models\Books;
use App\Models\Category;
use App\Models\Kelas;
use App\Models\Member;
use App\Models\Publisher;
use App\Models\Setting;
use App\Models\User;
use App\Service\MemberService;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@perpus.com',
            'password' => 'popo',
            'role' => 'Admin',
        ]);

        // kelas
        Kelas::create([
            'name' => '7 A'
        ]);
        Kelas::create([
            'name' => '7 B'
        ]);
        Kelas::create([
            'name' => '7 C'
        ]);
        Kelas::create([
            'name' => '7 D'
        ]);
        // 8
        Kelas::create([
            'name' => '8 A'
        ]);
        Kelas::create([
            'name' => '8 B'
        ]);
        Kelas::create([
            'name' => '8 C'
        ]);
        Kelas::create([
            'name' => '8 D'
        ]);
        // 9
        Kelas::create([
            'name' => '9 A'
        ]);
        Kelas::create([
            'name' => '9 B'
        ]);
        Kelas::create([
            'name' => '9 C'
        ]);
        Kelas::create([
            'name' => '9 D'
        ]);

        Publisher::create([
            'name' => 'Airlangga'
        ]);
        Publisher::create([
            'name' => 'CV PUSTAKA'
        ]);

        Category::create([
            'name' => 'Legenda'
        ]);
        Category::create([
            'name' => 'Fiksi'
        ]);

        Books::create([
            'title' => 'Avatar',
            'author' => 'Arjun',
            'publisher_id' => '1',
            'category_id' => '2',
            'isbn' => '10192929',
            'stock_rusak' => '20',
            'stock_baik' => '30',
            'stock' => '50',
            'jumlah_buku' => '50',
        ]);
        Books::create([
            'title' => 'Naruto',
            'author' => 'Arjun',
            'publisher_id' => '1',
            'category_id' => '1',
            'isbn' => '10192929',
            'stock_rusak' => '20',
            'stock_baik' => '30',
            'stock' => '50',
            'jumlah_buku' => '50',
        ]);
        Books::create([
            'title' => 'One Piece',
            'author' => 'Arjun',
            'publisher_id' => '1',
            'category_id' => '2',
            'isbn' => '10192929',
            'stock_rusak' => '20',
            'stock_baik' => '30',
            'stock' => '50',
            'jumlah_buku' => '50',
        ]);
        Books::create([
            'title' => 'Cinta Anak SMA',
            'author' => 'Arjun',
            'publisher_id' => '1',
            'category_id' => '2',
            'isbn' => '10192929',
            'stock_rusak' => '20',
            'stock_baik' => '30',
            'stock' => '50',
            'jumlah_buku' => '50',
        ]);
        Books::create([
            'title' => 'Kisah Kehidupan SMA',
            'author' => 'Arjun',
            'publisher_id' => '1',
            'category_id' => '2',
            'isbn' => '10192929',
            'stock_rusak' => '20',
            'stock_baik' => '30',
            'stock' => '50',
            'jumlah_buku' => '50',
        ]);
        Books::create([
            'title' => 'Keluarga Cemara',
            'author' => 'Arjun',
            'publisher_id' => '1',
            'category_id' => '2',
            'isbn' => '10192929',
            'stock_rusak' => '20',
            'stock_baik' => '30',
            'stock' => '50',
            'jumlah_buku' => '50',
        ]);
        Books::create([
            'title' => 'Pesantren Kenangan',
            'author' => 'Arjun',
            'publisher_id' => '1',
            'category_id' => '2',
            'isbn' => '10192929',
            'stock_rusak' => '20',
            'stock_baik' => '30',
            'stock' => '50',
            'jumlah_buku' => '50',
        ]);

        $this->call(MemberSeeder::class);


    }
}
