<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRoute extends Model
{
    use HasFactory;

    public function shippings()
    {
        return $this->hasManyThrough(Shipping::class, ShippingServiceType::class, 'shipping_service_type_id', 'id');
    }
}
