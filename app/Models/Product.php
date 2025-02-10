<?php

namespace App\Models;

use App\Enums\TaxType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // Nom explicite de la table

    protected $guarded = ['id']; // Protection contre l'assignation massive

    protected $fillable = [
        'name', 'slug', 'code', 'quantity', 'stock_min',
        'buying_price', 'selling_price', 'tax', 'tax_type',
        'notes', 'product_image', 'category_id', 'unit_id',
        'user_id', 'uuid', 'validated', 'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tax_type' => TaxType::class,
    ];

    /**
     * Permet d'utiliser le slug au lieu de l'ID dans les routes.
     */
    // Définir le statut du produit
    public function getStatusAttribute()
    {
        if (!$this->validated) return 'pending';
        if ($this->quantity <= 0) return 'out_of_stock';
        if ($this->quantity < $this->stock_min) return 'low_stock';
        return 'approved';
    }
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Relation avec la catégorie du produit.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relation avec l'unité du produit.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Relation avec l'utilisateur qui a créé le produit.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Convertir les prix en centimes pour éviter les erreurs d'arrondi.
     */
    protected function buyingPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => round($value * 100),
        );
    }

    protected function sellingPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => round($value * 100),
        );
    }

    /**
     * Scope pour la recherche des produits par nom ou code.
     */
    public function scopeSearch($query, $value): void
    {
        $query->where('name', 'like', "%{$value}%")
              ->orWhere('code', 'like', "%{$value}%");
    }
    public function updateQuantity($newQuantity)
    {
        $this->quantity = $newQuantity;
        $this->save();
    }

    /**
     * Vérifie si le stock d’un produit est en dessous du seuil minimum.
     */
    public function isLowStock(): bool
    {
        return $this->quantity < $this->stock_min;
    }
    

   

}
