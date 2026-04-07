<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosyanduTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'kader_id',
        'tahun',
        'bulan',
        'sasaran_bumil',
    ];

    public function kader()
    {
        return $this->belongsTo(User::class, 'kader_id');
    }
}
