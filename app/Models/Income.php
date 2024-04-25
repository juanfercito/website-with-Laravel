<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table = 'incomes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'provider_id',
        'payment_proof',
        'proof_number',
        'date_time',
        'fee_tax',
        'status',
    ];

    protected $guarded = [];
}
