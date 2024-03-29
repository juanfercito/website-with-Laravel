<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'product_class_id',
        'product_category_id',
        'product_type_id',
        'description',
        'image',
        'price',
        'cant',
    ];

    public function productClass()
    {
        return $this->belongsTo(ProductClass::class, 'product_class_id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
