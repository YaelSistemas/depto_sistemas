<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaCartucho extends Model
{
    protected $table = 'entrega_cartuchos';

    protected $fillable = [
        'colaborador_id',
        'fecha_asignacion',
        'motivo_entrega',
        'fecha_entrega',
        'personal_entrego',
        'personal_recibio',
        'personal_autorizo',
        'unidad',
        'area'
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'cartucho_producto')
            ->withPivot('cantidad_asignada')
            ->withTimestamps();
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }

    public function entrego()
    {
        return $this->belongsTo(User::class, 'personal_entrego');
    }

    public function recibio()
    {
        return $this->belongsTo(Colaborador::class, 'personal_recibio');
    }

    public function autorizo()
    {
        return $this->belongsTo(User::class, 'personal_autorizo');
    }
}
