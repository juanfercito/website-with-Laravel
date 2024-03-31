<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingServiceType extends Model
{
    use HasFactory;

    public function shippings()
    {
        return $this->hasMany(Shipping::class, 'id');
    }
}
