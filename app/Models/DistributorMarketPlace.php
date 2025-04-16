<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorMarketPlace extends Model
{
    protected $fillable = [
        'distributor_id',
        'market_place_id',
        'url',
    ];
    
}
