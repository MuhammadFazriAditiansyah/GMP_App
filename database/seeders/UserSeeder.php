<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admingmp'),
            'role' => 'admin',
            'department' => 'QA',
            'is_verified' => true,
        ]);

        User::create([
            'name' => 'Produksi',
            'email' => 'produksi@gmail.com',
            'password' => Hash::make('produksi'),
            'role' => 'user',
            'department' => 'Produksi',
            'is_verified' => true,
        ]);

        User::create([
            'name' => 'Warehouse',
            'email' => 'warehouse@gmail.com',
            'password' => Hash::make('warehouse'),
            'role' => 'user',
            'department' => 'Warehouse',
            'is_verified' => true,
        ]);

        User::create([
            'name' => 'Engineering',
            'email' => 'engineering@gmail.com',
            'password' => Hash::make('engineering'),
            'role' => 'user',
            'department' => 'Engineering',
            'is_verified' => true,
        ]);

        User::create([
            'name' => 'Human Resources',
            'email' => 'hrgmp@gmail.com',
            'password' => Hash::make('hrusergmp'),
            'role' => 'user',
            'department' => 'HR',
            'is_verified' => true,
        ]);

        User::create([
            'name' => 'Quality Assurance',
            'email' => 'qagmp@gmail.com',
            'password' => Hash::make('qausergmp'),
            'role' => 'user',
            'department' => 'QA',
            'is_verified' => true,
        ]);

    }
}
