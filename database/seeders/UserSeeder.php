<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Direktur — akses penuh
        User::updateOrCreate(
            ['username' => 'direktur'],
            [
                'name' => 'Winardo Mardanus',
                'password' => Hash::make('admin123'),
                'role' => 'direktur',
            ]
        );

        // Akun Pegawai — CRUD transaksi, master read-only
        User::updateOrCreate(
            ['username' => 'pegawai'],
            [
                'name' => 'Andi Pratama',
                'password' => Hash::make('staff123'),
                'role' => 'pegawai',
            ]
        );
    }
}
