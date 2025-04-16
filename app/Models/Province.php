<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    protected $fillable = [
        'name',
        'alt_name',
        'slug',
        'latitude',
        'longitude',
    ];

    public function regencies()
    {
        return $this->hasMany(Regency::class);
    }

}
