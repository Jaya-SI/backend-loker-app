<?php

namespace App\Models;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelamar extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'img_pelamar',
        'email',
        'password',
        'alamat',
        'no_hp',
        'jenis_kelamin',
        'role',
        'token',
        'cv',
    ];

    public function getimgPelamarAttribute($value)
    {
        return env('ASSET_URL')."/".$value;
    }

    public function getCvAttribute($value)
    {
        return env('ASSET_URL')."/".$value;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
