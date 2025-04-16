<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPlace extends Model
{
    protected $fillable = ['name', 'icon'];

    public function getIconUrlAttribute()
    {
        return asset('storage/icons/' . $this->icon);
    }
}
