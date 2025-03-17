<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'descricao',
        'valor',
        'data',
        'categoria_id',
        'metodo_pagamento',
        'pago',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    protected function casts(): array
    {
        return [
            'data' => 'date',
        ];
    }
}
