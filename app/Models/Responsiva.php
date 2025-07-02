<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsiva extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'usuario_id',
        'fecha_asignacion',
        'colaborador_id',
        'fecha_entrega',
        'motivo_entrega',
        'personal_entrego',
        'personal_recibio',
        'personal_autorizo',
        'firma_recibio', // ✅ necesario para guardar la ruta de la firma
    ];


    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class, 'colaborador_id');
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

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'responsiva_productos')
            ->withPivot('cantidad_asignada')
            ->withTimestamps();
    }
}
