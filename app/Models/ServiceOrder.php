<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'customer_id',
        'device_model_id',
        'serial_number',
        'status_id',
        'problem_description',
        'diagnosis',
        'solution',
        'estimated_cost',
        'final_cost',
        'estimated_delivery_date',
        'delivery_date',
        'notes',
        'user_id'
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
        'estimated_delivery_date' => 'date',
        'delivery_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deviceModel()
    {
        return $this->belongsTo(DeviceModel::class);
    }

    public function status()
    {
        return $this->belongsTo(ServiceOrderStatus::class, 'status_id');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status->slug) {
            'pendiente' => 'warning',
            'en-diagnostico' => 'info',
            'esperando-aprobacion' => 'primary',
            'en-reparacion' => 'secondary',
            'listo-para-entrega' => 'success',
            'entregado' => 'dark',
            'cancelado' => 'danger',
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
        return $query->whereHas('status', function($q) {
            $q->where('slug', 'pendiente');
        });
    }

    public function scopeInDiagnosis($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('slug', 'en-diagnostico');
        });
    }

    public function scopeWaitingApproval($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('slug', 'esperando-aprobacion');
        });
    }

    public function scopeInRepair($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('slug', 'en-reparacion');
        });
    }

    public function scopeReady($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('slug', 'listo-para-entrega');
        });
    }

    public function scopeDelivered($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('slug', 'entregado');
        });
    }

    public function scopeCancelled($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('slug', 'cancelado');
        });
    }
}
