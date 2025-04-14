<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'villages';

    protected $fillable = [
        'id',
        'district_id',
        'name',
        'slug',
        'latitude',
        'longitude',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function regency()
    {
        return $this->hasOneThrough(
            Regency::class,
            District::class,
            'id',
            'id',
            'district_id',
            'regency_id'
        );
    }

    public function province()
    {
        return $this->hasOneThrough(
            Province::class,
            Regency::class,
            'id',
            'id',
            'regency_id',
            'province_id'
        );
    }
}
