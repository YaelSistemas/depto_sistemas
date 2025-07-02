<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsivaProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'responsiva_id',
        'producto_id',
        'cantidad_asignada',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function responsiva()
    {
        return $this->belongsTo(Responsiva::class, 'responsiva_id');
    }
}
