<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'entradas';

    public function documentos()
    {
        return $this->belongsToMany(Documento::class, 'documento_entrada')->withTimestamps();
    }

    public function documentos_orden()
    {
        return $this->documentos()->where('tipo', 'orden_compra');
    }

    public function documentos_factura()
    {
        return $this->documentos()->where('tipo', 'factura');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
