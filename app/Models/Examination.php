<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'tanggal_pemeriksaan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'lila',
        'tekanan_darah',
        'suhu',
        'tfu',
        'djj',
        'naik_berat_badan',
        'bgm',
        'vitamin_a',
        'tablet_fe',
        'is_kek',
        'status_stunting',
        'asupan_gizi',
        'imunisasi_gizi',
        'catatan',
        'kader_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function kader()
    {
        return $this->belongsTo(User::class, 'kader_id');
    }
}
