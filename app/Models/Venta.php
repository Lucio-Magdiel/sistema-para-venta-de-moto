<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'moto_id',
        'user_id',
        'precio_venta',
        'metodo_pago',
        'observaciones',
        'fecha_venta',
    ];

    protected $casts = [
        'precio_venta' => 'decimal:2',
        'fecha_venta' => 'datetime',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function moto(): BelongsTo
    {
        return $this->belongsTo(Moto::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
