<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'proof_type',
        'proof_number',
        'date_time',
        'fee_tax',
        'sale_total',
        'status',
    ];

    protected $guarded = [];

    public function saleDetails()
    {
        return $this->hasOne(SaleDetail::class);
    }
}
