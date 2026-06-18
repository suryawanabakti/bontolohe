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
        'hpht',
        'status_stunting',
        'asupan_gizi',
        'imunisasi_gizi',
        'catatan',
        'kader_id',
    ];

    protected $appends = ['hpl', 'umur_kehamilan'];

    public function getHplAttribute()
    {
        if (!$this->hpht) return null;
        return \Carbon\Carbon::parse($this->hpht)->addDays(280)->toDateString();
    }

    public function getUmurKehamilanAttribute()
    {
        if (!$this->hpht) return null;
        $from = \Carbon\Carbon::parse($this->hpht);
        $to = $this->tanggal_pemeriksaan
            ? \Carbon\Carbon::parse($this->tanggal_pemeriksaan)
            : \Carbon\Carbon::now();
        return (int) $from->diffInWeeks($to);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function kader()
    {
        return $this->belongsTo(User::class, 'kader_id');
    }
}
