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
        'stock',
        'status', // Asegúrate de incluir el campo 'status' en los atributos masivos (mass assignable)
    ];

    protected $attributes = [
        'status' => 'Available',
    ];

    // Definición del evento para actualizar el campo 'status'
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($product) {
            // Actualizar el campo 'status' basado en la cantidad de unidades disponibles
            if ($product->stock > 0) {
                $product->status = 'Available';
            } else {
                $product->status = 'Unavailable';
            }
        });
    }

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

    public function incomeDetails()
    {
        return $this->hasMany(IncomeDetail::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
