<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashRegister extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'initial_balance',
        'final_balance',
        'total_income',
        'total_expense',
        'status',
        'opening_date',
        'closing_date',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
        'final_balance' => 'decimal:2',
        'total_income' => 'decimal:2',
        'total_expense' => 'decimal:2',
        'opening_date' => 'datetime',
        'closing_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movements()
    {
        return $this->hasMany(CashMovement::class);
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'OPEN');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'CLOSED');
    }

    // Métodos
    public function getCurrentBalanceAttribute()
    {
        return $this->initial_balance + $this->total_income - $this->total_expense;
    }

    public function canBeClosed()
    {
        return $this->status === 'OPEN';
    }

    public function close($finalBalance, $notes = null)
    {
        if (!$this->canBeClosed()) {
            return false;
        }

        $this->update([
            'status' => 'CLOSED',
            'final_balance' => $finalBalance,
            'closing_date' => now(),
            'notes' => $notes
        ]);

        return true;
    }
}
