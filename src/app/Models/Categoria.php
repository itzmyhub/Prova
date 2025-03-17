<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'categoria';

    protected $fillable = ['nome'];

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }
}
