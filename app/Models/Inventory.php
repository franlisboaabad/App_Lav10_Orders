<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'min_stock',
        'max_stock'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'min_stock' => 'integer',
        'max_stock' => 'integer'
    ];

    // Relaciones
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    // Scopes
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= min_stock');
    }

    public function scopeOverStock($query)
    {
        return $query->whereRaw('quantity >= max_stock');
    }

    // Métodos
    public function updateStock($quantity, $type = 'add')
    {
        if ($type === 'add') {
            $this->quantity += $quantity;
        } else {
            $this->quantity -= $quantity;
        }
        $this->save();
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->min_stock;
    }

    public function isOverStock()
    {
        return $this->quantity >= $this->max_stock;
    }
}