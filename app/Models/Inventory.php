<?php

namespace App\Models;

use App\Enums\TaxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'inventory';

    public $fillable = [
        'name',
        'code',
        'slug',
        'quantity',
        'category_id', // Correction ici
        'selling_price',
        'tax',
        'tax_type',
        'unit_id', // Ajout de l'attribut unit_id
        'created_at',
        'updated_at',
        'stock_phy',
        'user_id',
        'uuid'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tax_type' => TaxType::class
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    protected function sellingPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('code', 'like', "%{$value}%");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}