<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "provider_class_id",
        "provider_category_id",
        "description",
        "image",
        "location",
        "closing_order_date",
        "application_date",
        "status",
    ];

    public function providerClass()
    {
        return $this->belongsTo(ProviderClass::class, 'provider_class_id');
    }

    public function providerCategory()
    {
        return $this->belongsTo(ProviderCategory::class, 'provider_category_id');
    }
}
