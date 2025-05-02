<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'address',
        'primary_phone',
        'secondary_phone',
        'email',
        'agent_code',
        'google_maps_url',
        'image_url',
        'is_cod',
        'is_shipping',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function marketPlaces()
    {
        return $this->belongsToMany(MarketPlace::class, 'distributor_market_places')
                    ->withPivot('url')
                    ->withTimestamps();
    }
    
    public function marketPlaceDistributor()
    {
        return $this->hasMany(DistributorMarketPlace::class);
    }

    public function shipmentDistributor()
    {
        return $this->hasMany(DistributorShipment::class);
    }
    
    public function shipments()
    {
        return $this->belongsToMany(Shipment::class, 'distributor_shipments')->withTimestamps();
    }
    
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

}
