<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seleksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pelamar',
        'id_loker',
        'surat_lamaran',
        'status',
        'keterangan',
    ];

    public function idPelamar()
    {
        return $this->belongsTo('App\Models\Pelamar', 'id_pelamar', 'id');
    }

    public function idLoker()
    {
        return $this->belongsTo('App\Models\Loker', 'id_loker', 'id');
    }
}
