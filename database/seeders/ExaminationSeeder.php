<?php

namespace Database\Seeders;

use App\Models\Examination;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class ExaminationSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            // Generate 3 exam records for each patient (monthly)
            for ($i = 0; $i < 3; $i++) {
                $monthAgo = $i;
                $data = [
                    'patient_id' => $patient->id,
                    'tanggal_pemeriksaan' => now()->subMonths($monthAgo)->format('Y-m-d'),
                    'berat_badan' => $this->getWeight($patient, $monthAgo),
                    'tinggi_badan' => $this->getHeight($patient, $monthAgo),
                ];

                if ($patient->kategori === 'balita') {
                    $data['lingkar_kepala'] = 45 + (3 - $monthAgo);
                } elseif ($patient->kategori === 'ibu_hamil') {
                    $data['tfu'] = 20 + (5 - $monthAgo);
                    $data['djj'] = 145 - $i;
                    $data['catatan'] = 'Kondisi janin sehat dan normal.';
                }

                Examination::create($data);
            }
        }
    }

    private function getWeight($patient, $monthAgo)
    {
        if ($patient->kategori === 'balita') {
            return 10 - $monthAgo;
        } elseif ($patient->kategori === 'ibu_hamil') {
            return 60 + (3 - $monthAgo);
        }
        return 55;
    }

    private function getHeight($patient, $monthAgo)
    {
        if ($patient->kategori === 'balita') {
            return 80 - $monthAgo;
        } elseif ($patient->kategori === 'ibu_hamil') {
            return 158;
        }
        return 160;
    }
}

