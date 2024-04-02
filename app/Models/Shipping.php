<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shipping_service_type_id',
        'shipping_routes_id',
        'description',
        'image',
        'weight_cost',
        'size_cost',
        'total_cost',
        'estimated_delivery_time'
    ];

    public function shippingServiceTypes()
    {
        return $this->belongsTo(ShippingServiceType::class, 'shipping_service_type_id');
    }

    public function shippingRoutes()
    {
        return $this->belongsTo(ShippingRoute::class, 'shipping_route_id');
    }
}
