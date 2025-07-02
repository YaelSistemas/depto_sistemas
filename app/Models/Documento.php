<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'archivo'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'documento_producto')->withTimestamps();
    }
}
