<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'name',
        'code',
        'icon',
        'description',
        'is_active',
    ];
}
