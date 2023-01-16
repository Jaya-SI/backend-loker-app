<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_seleksi',
        'id_hrd',
        'id_pelamar',
        'jadwal',
        'token',
        'keterangan',
        'status',
    ];

    public function idSeleksi()
    {
        return $this->belongsTo('App\Models\Seleksi', 'id_seleksi');
    }

    public function idPelamar()
    {
        return $this->belongsTo('App\Models\Pelamar', 'id_pelamar');
    }

    public function idHrd()
    {
        return $this->belongsTo('App\Models\Hrd', 'id_hrd');
    }
}
