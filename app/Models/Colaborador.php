<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $table = 'colaboradores'; // Nombre real de la tabla

    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'empresa_id',
        'unidad_servicio_id',
        'area_departamento_id',
        'puesto',
    ];

    // ✅ Relación: un colaborador fue registrado por un usuario
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function responsivas()
    {
        return $this->hasMany(Responsiva::class);
    }

    public function area()
    {
        return $this->belongsTo(AreaDepartamento::class, 'area_departamento_id');
    }

    public function unidad()
    {
        return $this->belongsTo(UnidadServicio::class, 'unidad_servicio_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function unidadServicio()
    {
        return $this->belongsTo(UnidadServicio::class, 'unidad_servicio_id');
    }

    public function areaDepartamento()
    {
        return $this->belongsTo(AreaDepartamento::class, 'area_departamento_id');
    }
}
