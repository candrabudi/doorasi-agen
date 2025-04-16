<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorShipment extends Model
{
    protected $fillable = [
        'distributor_id',
        'shipment_id',
    ];
    
}
