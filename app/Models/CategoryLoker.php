<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryLoker extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_category',
        'img_category'
    ];

    public function getimgCategoryAttribute($value)
    {
        return env('ASSET_URL')."/".$value;
    }
}
