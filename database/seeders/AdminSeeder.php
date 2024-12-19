<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'root@root.com'], // Уникальное условие
            [
                'name' => 'admin',
                'password' => Hash::make('toor'),
                'is_admin' => true,
            ]
        );
        
        User::firstOrCreate(
            ['email' => 'user@ex.com'], // Уникальное условие
            [
                'name' => 'Обычный пользователь',
                'password' => Hash::make('exxx'),
                'is_admin' => false,
            ]
        );
    }
    
}