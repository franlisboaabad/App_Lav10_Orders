<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    const TYPE_ENTRY = 'entry';
    const TYPE_EXIT = 'exit';
    const TYPE_ADJUSTMENT = 'adjustment';

    protected $fillable = [
        'inventory_id',
        'type',
        'quantity',
        'previous_quantity',
        'current_quantity',
        'reference_type',
        'reference_id',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'previous_quantity' => 'integer',
        'current_quantity' => 'integer'
    ];

    // Relaciones
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeEntries($query)
    {
        return $query->where('type', self::TYPE_ENTRY);
    }

    public function scopeExits($query)
    {
        return $query->where('type', self::TYPE_EXIT);
    }

    public function scopeAdjustments($query)
    {
        return $query->where('type', self::TYPE_ADJUSTMENT);
    }

    // Métodos
    public static function createMovement($inventory, $type, $quantity, $reference = null, $notes = null)
    {
        $previousQuantity = $inventory->quantity;
        $currentQuantity = $type === self::TYPE_ENTRY
            ? $previousQuantity + $quantity
            : $previousQuantity - $quantity;

        $movement = self::create([
            'inventory_id' => $inventory->id,
            'type' => $type,
            'quantity' => $quantity,
            'previous_quantity' => $previousQuantity,
            'current_quantity' => $currentQuantity,
            'reference_type' => $reference ? get_class($reference) : null,
            'reference_id' => $reference ? $reference->id : null,
            'notes' => $notes,
            'user_id' => auth()->id()
        ]);

        $inventory->update(['quantity' => $currentQuantity]);

        return $movement;
    }
}
