<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'customer_id',
        'device_model_id',
        'serial_number',
        'problem_description',
        'diagnosis',
        'solution',
        'estimated_cost',
        'final_cost',
        'status',
        'estimated_delivery_date',
        'delivery_date',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
        'estimated_delivery_date' => 'date',
        'delivery_date' => 'date',
        'is_active' => 'boolean'
    ];

    // Relaciones
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deviceModel()
    {
        return $this->belongsTo(DeviceModel::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'PENDING' => 'warning',
            'IN_DIAGNOSIS' => 'info',
            'WAITING_APPROVAL' => 'primary',
            'IN_REPAIR' => 'secondary',
            'READY' => 'success',
            'DELIVERED' => 'dark',
            'CANCELLED' => 'danger',
            default => 'secondary',
        };
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    public function scopeInProgress($query)
    {
        return $query->whereIn('status', ['IN_DIAGNOSIS', 'WAITING_APPROVAL', 'IN_REPAIR']);
    }

    public function scopeReady($query)
    {
        return $query->where('status', 'READY');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'DELIVERED');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'CANCELLED');
    }
}
