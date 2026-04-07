<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'kategori',
        'has_kms',
        'kader_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) return '-';
        $diff = \Carbon\Carbon::parse($this->tanggal_lahir)->diff(now());
        return "{$diff->y} thn, {$diff->m} bln";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kader()
    {
        return $this->belongsTo(User::class, 'kader_id');
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }
}
