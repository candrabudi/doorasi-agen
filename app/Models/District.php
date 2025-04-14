<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = [
        'id',
        'regency_id',
        'name',
        'alt_name',
        'slug',
        'latitude',
        'longitude',
    ];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
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
