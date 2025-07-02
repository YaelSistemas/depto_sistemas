<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'user_id',
        'categoria_id',
        'proveedor_id',
        'nombre',
        'descripcion',
        'cantidad',
        'marca',
        'modelo',
        'no_serie',
        'precio',
        'activo',
        'imagen',
        'ram',
        'procesador',
        'tipo_almacenamiento',
        'capacidad_almacenamiento',
        'fecha_compra',
        'orden_compra',
        'factura',
    ];

    protected $casts = [
        'orden_compra' => 'array',
        'factura' => 'array',
        'fecha_compra' => 'date',
    ];

    public function responsivas()
    {
        return $this->belongsToMany(Responsiva::class, 'responsiva_productos')
            ->withPivot('cantidad_asignada')
            ->withTimestamps();
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function documentos()
    {
        return $this->belongsToMany(Documento::class, 'documento_producto')->withTimestamps();
    }

    public function documentos_orden()
    {
        return $this->belongsToMany(Documento::class, 'documento_producto', 'producto_id', 'documento_id')
            ->where('tipo', 'orden_compra');
    }

    public function documentos_factura()
    {
        return $this->belongsToMany(Documento::class, 'documento_producto', 'producto_id', 'documento_id')
            ->where('tipo', 'factura');
    }

    public function entregas_cartuchos()
    {
        return $this->belongsToMany(EntregaCartucho::class, 'cartucho_producto', 'producto_id', 'entrega_cartucho_id')
            ->withPivot('cantidad_asignada')
            ->withTimestamps();
    }
}
