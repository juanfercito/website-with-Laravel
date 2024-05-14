<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'proof_type',
        'proof_number',
        'tax_fee',
        'sale_total',
        'status',
    ];

    protected $guarded = [];

    protected $dates = ['date_time']; // Agregar el campo date_time a los atributos de fecha/hora

    // Utilizar el evento creating para establecer la fecha y hora automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            $sale->date_time = Carbon::now('America/Guayaquil');
        });
    }

    public function saleDetails()
    {
        return $this->hasOne(SaleDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
