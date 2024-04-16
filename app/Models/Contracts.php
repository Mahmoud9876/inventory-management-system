<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contracts extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'supplier_id',
        'start_date',
        'end_date',
        'contract_id',
        'product_id',
        'payment_terms',
        'ordered_quantity',
        'unit_price',
        'contract_terms',
        'contract_status',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'supplier_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'product_id' => 'integer',
        'payment_terms' => 'string',
        'ordered_quantity' => 'integer', 
        'contract_status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
public function products()
{
    return $this->belongs(Product::class);
}
    
}