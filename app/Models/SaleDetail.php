<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = 'sale_details';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'sale_id',
        'product_id',
        'cant',
        'sale_price',
        'discount',
    ];

    protected $guarded = [];

    public function sales()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
