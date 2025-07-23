<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan pakai namespace model User
use Illuminate\Support\Facades\Hash;

class PengawasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pengawas',
            'email' => 'pengawas@gmail.com',
            'role' => 'pengawas',
            'password' => Hash::make('123456'),
        ]);
    }
}
