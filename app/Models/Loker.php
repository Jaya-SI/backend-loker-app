<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loker extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id_category',
        'id_hrd',
        'nama',
        'img_loker',
        'alamat',
        'tanggal',
        'deskripsi1',
        'deskripsi2',
        'deskripsi3',
        'gaji',
        'status',
    ];

    public function idCategory()
    {
        return $this->belongsTo(CategoryLoker::class, 'id_category');
    }

    public function idHrd()
    {
        return $this->belongsTo(Hrd::class, 'id_hrd');
    }

    public function getimgLokerAttribute($value)
    {
        return env('ASSET_URL')."/".$value;
    }
}
