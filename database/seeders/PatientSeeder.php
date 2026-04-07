<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $ibuHamilUser = User::role('ibu_hamil')->first();
        $orangTuaUser = User::role('orang_tua')->first();

        // Ibu Hamil Patients
        Patient::create([
            'user_id' => $ibuHamilUser?->id,
            'nama' => 'Siti Aminah',
            'tanggal_lahir' => '1995-05-15',
            'jenis_kelamin' => 'P',
            'kategori' => 'ibu_hamil',
        ]);

        Patient::create([
            'nama' => 'Dewi Lestari',
            'tanggal_lahir' => '1998-12-10',
            'jenis_kelamin' => 'P',
            'kategori' => 'ibu_hamil',
        ]);

        // Balita Patients
        Patient::create([
            'user_id' => $orangTuaUser?->id,
            'nama' => 'Ahmad Rafif',
            'tanggal_lahir' => now()->subYears(2)->subMonths(3)->format('Y-m-d'),
            'jenis_kelamin' => 'L',
            'kategori' => 'balita',
        ]);

        Patient::create([
            'nama' => 'Zaskia Adya',
            'tanggal_lahir' => now()->subMonths(8)->format('Y-m-d'),
            'jenis_kelamin' => 'P',
            'kategori' => 'balita',
        ]);

    }
}

