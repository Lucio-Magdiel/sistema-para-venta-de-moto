<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Moto extends Model
{
    use HasFactory;

    protected $fillable = [
        'marca',
        'modelo',
        'año',
        'color',
        'cilindrada',
        'precio',
        'stock',
        'descripcion',
        'imagen',
        'estado',
    ];

    protected $casts = [
        'año' => 'integer',
        'cilindrada' => 'integer',
        'precio' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class);
    }
}
