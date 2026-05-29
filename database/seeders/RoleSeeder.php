<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'kader_posyandu',
            'ibu_hamil',
            'orang_tua',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@posyandu.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        $kader = User::firstOrCreate(
            ['email' => 'kader@posyandu.com'],
            [
                'name' => 'Kader Posyandu',
                'password' => Hash::make('password'),
            ]
        );
        $kader->assignRole('kader_posyandu');

        // Create default ibu hamil
        $ibu = User::firstOrCreate(
            ['email' => 'ibu@example.com'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('password'),
            ]
        );
        $ibu->assignRole('ibu_hamil');

        // Create default orang tua
        $ortu = User::firstOrCreate(
            ['email' => 'ortu@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
            ]
        );
        $ortu->assignRole('orang_tua');

        // Create another kader
        $kader2 = User::firstOrCreate(
            ['email' => 'kader2@posyandu.com'],
            [
                'name' => 'Nur Azizah',
                'password' => Hash::make('password'),
            ]
        );
        $kader2->assignRole('kader_posyandu');
    }
}
