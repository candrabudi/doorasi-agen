<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'regencies';

    protected $fillable = [
        'id',
        'province_id',
        'name',
        'alt_name',
        'slug',
        'latitude',
        'longitude',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function distributors()
    {
        return $this->hasMany(Distributor::class);
    }


}
