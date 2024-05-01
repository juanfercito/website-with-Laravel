<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeDetail extends Model
{
    use HasFactory;

    protected $table = 'income_details';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'income_id',
        'product_id',
        'cant',
        'purchase_price',
        'sale_price',
    ];

    protected $guarded = [];

    public function income()
    {
        return $this->belongsTo(Income::class);
    }
}
