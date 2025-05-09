<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashMovement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cash_register_id',
        'user_id',
        'type',
        'amount',
        'description',
        'reference',
        'payment_method',
        'notes',
        'is_active'
    ];

    public const INGRESO = 'INCOME';
    public const GASTO = 'EXPENSE';
    public const EFECTIVO = 'CASH';
    public const TRANSFERENCIA = 'TRANSFERENCE';
    public const TARJETA_CREDITO = 'CARD';

    protected $casts = [
        'amount' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relaciones
    public function cashRegister()
    {
        return $this->belongsTo(CashRegister::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeIncome($query)
    {
        return $query->where('type', 'INCOME');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'EXPENSE');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Métodos
    public function isIncome()
    {
        return $this->type === 'INCOME';
    }

    public function isExpense()
    {
        return $this->type === 'EXPENSE';
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($movement) {
            $register = $movement->cashRegister;

            if ($movement->isIncome()) {
                $register->increment('total_income', $movement->amount);
            } else {
                $register->increment('total_expense', $movement->amount);
            }
        });

        static::deleted(function ($movement) {
            $register = $movement->cashRegister;

            if ($movement->isIncome()) {
                $register->decrement('total_income', $movement->amount);
            } else {
                $register->decrement('total_expense', $movement->amount);
            }
        });
    }
}
